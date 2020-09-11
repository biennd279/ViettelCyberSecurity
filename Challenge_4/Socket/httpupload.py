import argparse
import re
from urllib.parse import urlparse

from tcplib.tcplib import *


def getFileContent(uri: str):
    file = open(uri, "r+b")
    file_name = uri.split("/")[-1]
    content = file.read()
    file.close()
    return file_name, content


def getPostLogin(url: str, user: str, password: str):
    url = urlparse(url)

    sock = createSocket(url.hostname, url.port or 80)

    body = "log={user}&pwd={password}" \
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

    return ''.join(cookies)[:]


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


def getFileUploadUrl(id:int, url:str, cookies:str):
    url = urlparse(url)

    sock = createSocket(url.hostname, url.port or 80)

    msg = "GET /wp-admin/post.php?post={id}&action=edit HTTP/1.1\r\n" \
          "Host: {host}\r\n" \
          "Cookie: {cookies}\r\n" \
          "Connection: close\r\n" \
          "\r\n".format(id=id,
                        host=url.hostname,
                        cookies=cookies)

    response = sendTcpMsg(sock, msg.encode())

    header, body = parseTcpMsg(response.decode())

    url_regex = r"name=\"attachment_url\" id=\"attachment_url\" value=\"(.+?)\" \/>"

    url = re.search(url_regex, body)

    return url.group(1)


def uploadFile(url: str, user: str, password: str, uri: str):
    url = urlparse(url)

    image_name, file_content = getFileContent(uri)

    cookies = getCookies("{url}/wp-login.php".format(url=url.geturl()), user, password)

    _wpnonce = getWpnonce("{url}/wp-admin/media-new.php".format(url=url.geturl()), cookies)

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
           "Host: {host}\r\n" \
           "Content-Length: {content_length}\r\n" \
           "Content-Type: multipart/form-data; boundary={boundary}\r\n" \
           "Cookie: {cookies}\r\n" \
           "Connection: close\r\n" \
           "\r\n".format(host=url.netloc,
                         boundary=boundary,
                         content_length=len(body),
                         cookies=cookies)
    msg = b"%s" \
          b"%s" % (_msg.encode(),
                   body)

    sock = createSocket(url.hostname, url.port or 80)

    response = sendTcpMsg(sock, msg)

    sock.close()

    header, body = parseTcpMsg(response.decode())

    status_line = header.split("\r\n")[0]
    status_code = status_line.split(" ")[1]

    if status_code != "200":
        print("Can not upload file!")
    else:
        url = getFileUploadUrl(body, url.geturl(), cookies)
        print("Login Success. Upload file url: {url}".format(url=url))


if __name__ == '__main__':
    # print(getCookies("http://45.32.110.240/wp-login.php", "test", "test123QWE@AD"))
    # uploadFile("http://45.32.110.240/", "test", "test123QWE@AD", "okela-21.jpg")

    parse = argparse.ArgumentParser(description="Check login user and password")
    parse.add_argument("--url", help="URL")
    parse.add_argument("--user", help="User")
    parse.add_argument("--password", help="Password")
    parse.add_argument("--local-file", help="Path to file")

    args = parse.parse_args()

    url = args.url
    user = args.user
    password = args.password
    local_file = args.local_file

    uploadFile(url, user, password, local_file)
