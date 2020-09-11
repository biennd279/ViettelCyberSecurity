import socket as sk
from urllib.parse import urlparse
from tcplib import parseTcpMsg
from tcplib import createSocket
from tcplib import sendTcpMsg
import re


def getFileContent(uri: str):
    file = open(uri, "r+b")
    file_name = uri.split("/")[-1]
    content = file.read()
    file.close()
    return file_name, content


def getPostLogin(url: str, user: str, password: str):
    url = urlparse(url)

    sock = createSocket(url.hostname, url.port or 80)

    body = "log={user}&pwd={password}&testcookie=1" \
        .format(user=user, password=password)

    msg = "POST {path} HTTP/1.1\r\n" \
          "Host: {host}\r\n" \
          "Content-Length: {content_length}\r\n" \
          "Content-Type: application/x-www-form-urlencoded\r\n" \
          "Cookie: wordpress_test_cookie=WP+Cookie+check\r\n" \
          "Connection: close\r\n" \
          "\r\n" \
          "{body}".format(path=url.path,
                          host=url.netloc,
                          content_length=len(body),
                          body=body)

    response = sendTcpMsg(sock, msg.encode())

    sock.close()
    return response


def getCookies(url: str, user: str, password: str):
    response = getPostLogin(url, user, password).decode()
    header, body = parseTcpMsg(response)

    cookies_regex = r"Set-Cookie: (.+?; )"
    cookies = set(re.findall(cookies_regex, header))

    return ''.join(cookies)[0:-2]


def getWpnonce(url: str, cookie: str):
    url = urlparse(url)

    sock = createSocket(url.hostname, url.port or 80)

    msg = "GET /wp-admin/media-new.php HTTP/1.1\r\n" \
          "Host: {host}\r\n" \
          "Cookie: {cookie}\r\n" \
          "Connection: close\r\n" \
          "\r\n".format(host=url.netloc,
                        cookie=cookie)

    response = sendTcpMsg(sock, msg.encode())

    sock.close()

    header, body = parseTcpMsg(response.decode())

    json = re.search(r"\"post_id\":0,\"_wpnonce\":\"([\w\d]+)\",\"type\":\"\",\"tab\":\"\",\"short\":\"1\"", body)

    return json.group(1)


def uploadFile(url: str, user: str, password: str, uri: str):

    url = urlparse(url)

    image_name, file_content = getFileContent(uri)

    cookies = getCookies("http://45.32.110.240/wp-login.php", "test", "test123QWE@AD")

    _wpnonce = getWpnonce("http://45.32.110.240/wp-admin/media-new.php", cookies)

    boundary = "----WebKitFormBoundaryh3d42A0ad5Vv4VxY"

    _body = "--{boundary}\r\n" \
            "Content-Disposition: form-data; name=\"name\"\r\n" \
            "\r\n" \
            "{image_name}\r\n" \
            "--{boundary}\r\n" \
            "Content-Disposition: form-data; name=\"_wpnonce\"\r\n" \
            "\r\n" \
            "{_wpnonce}\r\n" \
            "--{boundary}\r\n" \
            "Content-Disposition: form-data; name=\"async-upload\"; filename=\"{image_name}\"\r\n" \
            "Content-Type: image/jpge\r\n" \
            "\r\n".format(boundary=boundary,
                          image_name=image_name,
                          _wpnonce=_wpnonce)

    body = b"%s" \
           b"%s\r\n" \
           b"--%s\r\n" % (_body.encode(),
                          file_content,
                          boundary.encode())

    _msg = "POST /wp-admin/async-upload.php HTTP/1.1\r\n" \
           "Host: 45.32.110.240\r\n" \
           "Content-Length: {content_length}\r\n" \
           "Content-Type: multipart/form-data; boundary={boundary}\r\n" \
           "Cookie: {cookies}\r\n" \
           "Connection: close\r\n" \
           "\r\n".format(boundary=boundary,
                         content_length=len(body),
                         cookies=cookies)
    msg = b"%s" \
          b"%s" % (_msg.encode(),
                   body)

    sock = createSocket(url.hostname, url.port or 80)

    response = sendTcpMsg(sock, msg)

    sock.close()

    print(response)


if __name__ == '__main__':
    # print(getCookies("http://45.32.110.240/wp-login.php", "test", "test123QWE@AD"))
    # uploadFile("http://45.32.110.240/wp-admin/async-upload.php", "test", "test123QWE@AD", "okela-21.jpg")
    url = urlparse("http://45.32.110.240/wp-admin/async-upload.php")
    print(url.fragment)
