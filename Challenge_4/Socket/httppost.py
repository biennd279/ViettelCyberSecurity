import socket as sk
from urllib.parse import urlparse
from tcplib import parseTCPMsg


def checkLoginMethod(url: str, user: str, password: str):
    url = urlparse(url)
    sock = sk.socket(sk.AF_INET, sk.SOCK_STREAM)
    sock.connect((url.hostname, url.port or 80))

    body = "log={user}&pwd={password}" \
        .format(user=user, password=password)

    msg = 'POST {path} HTTP/1.1\r\n' \
          'Host: {host}\r\n' \
          'Content-Length: {content_length}\r\n' \
          'Content-Type: application/x-www-form-urlencoded\r\n' \
          'Connection: close\r\n' \
          '\r\n' \
          '{body}' \
        .format(path=url.path,
                host=url.netloc,
                content_length=len(body),
                body=body)

    sock.sendall(msg.encode())
    response = ""
    while True:
        chunk = sock.recv(4096)
        if not chunk:
            break
        response += chunk.decode("utf-8")
    sock.close()

    header, body = parseTCPMsg(response)

    statusLine = header.split("\r\n")[0]
    statusCode = statusLine.split(" ")[1]

    if statusCode == "302":
        return True
    else:
        return False


if __name__ == '__main__':
    print(checkLoginMethod("http://45.32.110.240/wp-login.php", "test", "test123QWE@AD"))
