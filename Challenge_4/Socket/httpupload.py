import socket as sk
from urllib.parse import urlparse
from tcplib import parseTCPMsg
import re


def getFileContent(uri: str):
    file = open(uri, "r+b")
    content = file.read()
    file.close()
    return content


def getPostLogin(url: str, user: str, password: str):
    url = urlparse(url)

    sock = sk.socket(sk.AF_INET, sk.SOCK_STREAM)
    sock.connect((url.hostname, url.port or 80))

    body = "log={user}&pwd={password}&testcookie=1" \
        .format(user=user, password=password)

    msg = 'POST {path} HTTP/1.1\r\n' \
          'Host: {host}\r\n' \
          'Content-Length: {content_length}\r\n' \
          'Content-Type: application/x-www-form-urlencoded\r\n' \
          'Cookie: wordpress_test_cookie=WP+Cookie+check\r\n' \
          'Connection: close\r\n' \
          '\r\n' \
          '{body}' \
        .format(path=url.path,
                host=url.netloc,
                content_length=len(body),
                body=body)

    sock.sendall(msg.encode())
    response = b""
    while True:
        chunk = sock.recv(4096)
        if not chunk:
            break
        response += chunk

    sock.close()
    return response


def getCookies(url: str, user: str, password: str):
    response = getPostLogin(url, user, password).decode()
    header, body = parseTCPMsg(response)

    cookiesRegex = r"Set-Cookie: (.+?; )"
    cookies = set(re.findall(cookiesRegex, header))

    return ''.join(cookies)[0:-2]

def getWpnonce(url: str, cookie:str):
    url = urlparse(url)

    sock = sk.socket(sk.AF_INET, sk.SOCK_STREAM)
    sock.connect((url.hostname, url.port or 80))

    msg = "GET /wp-admin/media-new.php HTTP/1.1\r\n" \
          "Host: {host}\r\n" \
          "Cookie: {cookie}\r\n" \
          "Connection: close\r\n" \
          "\r\n".format(host=url.netloc,
                        cookie=cookie)

    sock.sendall(msg.encode())
    response = b""
    while True:
        chunk = sock.recv(4096)
        if not chunk:
            break
        response += chunk

    sock.close()

    header, body = parseTCPMsg(response.decode())

    json = re.search(r"\"post_id\":0,\"_wpnonce\":\"([\w\d]+)\",\"type\":\"\",\"tab\":\"\",\"short\":\"1\"", body)

    return json.group(1)


def uploadFile(url: str, user: str, password: str, uri: str):
    fileContent = getFileContent(uri)

    cookies = getCookies("http://45.32.110.240/wp-login.php", "test", "test123QWE@AD")

    _wpnoce = getWpnonce("http://45.32.110.240/wp-admin/media-new.php", cookies)

    # cookies = "wordpress_2dee28ae052fe27155f70bc8d3ceb583=test%7C1599939377%7CfCIkZI8RLFcUDgzytLhlHknIo0dtWbpjwLINGycFa3v%7Cf4ea102fd750c3c5b004f7b826fe1184f0b57bc1f16037434a8cfac5173d5b42; wordpress_test_cookie=WP+Cookie+check; wordpress_logged_in_2dee28ae052fe27155f70bc8d3ceb583=test%7C1599939377%7CfCIkZI8RLFcUDgzytLhlHknIo0dtWbpjwLINGycFa3v%7C1e0b7696b9e9cd39fa7e83181ca233e90f99fa5a41f756a443899ad3a4076fd2;"
    boundary = b"----WebKitFormBoundaryh3d42A0ad5Vv4VxY"


    body = b"--%s\r\n" \
           b"Content-Disposition: form-data; name=\"name\"\r\n" \
           b"\r\n" \
           b"test.png\r\n" \
           b"--%s\r\n" \
           b"Content-Disposition: form-data; name=\"_wpnonce\"\r\n" \
           b"\r\n" \
           b"%s\r\n" \
           b"--%s\r\n" \
           b"Content-Disposition: form-data; name=\"async-upload\"; filename=\"test.png\"\r\n" \
           b"Content-Type: image/png\r\n" \
           b"\r\n" \
           b"%s\r\n" \
           b"--%s\r\n" \
           b"" % (boundary,
                  boundary,
                  _wpnoce.encode(),
                  boundary,
                  fileContent,
                  boundary)

    msg = b"POST /wp-admin/async-upload.php HTTP/1.1\r\n" \
          b"Host: 45.32.110.240\r\n" \
          b"Content-Length: %s\r\n" \
          b"Content-Type: multipart/form-data; boundary=%s\r\n" \
          b"Cookie: %s\r\n" \
          b"Connection: close\r\n" \
          b"\r\n" \
          b"%s" % (len(body).__str__().encode(),
                   boundary,
                   cookies.encode(),
                   body)

    file = open("msg1.txt", "w+b")
    file.write(msg)
    file.close()

    print(msg)

    url = urlparse(url)

    sock = sk.socket(sk.AF_INET, sk.SOCK_STREAM)
    sock.connect((url.hostname, url.port or 80))

    sock.sendall(msg)

    response = b""
    while True:
        chunk = sock.recv(4096)
        if not chunk:
            break
        response += chunk

    sock.close()

    print(response)


if __name__ == '__main__':
    # print(getCookies("http://45.32.110.240/wp-login.php", "test", "test123QWE@AD"))
    uploadFile("http://45.32.110.240/wp-admin/async-upload.php", "test", "test123QWE@AD", "./cat-6.jpg")
