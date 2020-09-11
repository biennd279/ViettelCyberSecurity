import argparse
from urllib.parse import urlparse

from tcplib import createSocket
from tcplib import parseTcpMsg
from tcplib import sendTcpMsg


def checkLoginMethod(url: str, user: str, password: str):
    url = urlparse(url)
    sock = createSocket(url.hostname, url.port or 80)

    body = "log={user}&pwd={password}" \
        .format(user=user, password=password)

    msg = 'POST {path} HTTP/1.1\r\n' \
          'Host: {host}\r\n' \
          'Content-Length: {content_length}\r\n' \
          'Content-Type: application/x-www-form-urlencoded\r\n' \
          'Connection: close\r\n' \
          '\r\n' \
          '{body}' \
        .format(path="/wp-login.php",
                host=url.netloc,
                content_length=len(body),
                body=body)

    response = sendTcpMsg(sock, msg.encode())

    sock.close()

    header, body = parseTcpMsg(response.decode())

    status_line = header.split("\r\n")[0]
    status_code = status_line.split(" ")[1]

    if status_code == "302":
        return True
    else:
        return False


if __name__ == '__main__':
    # print(checkLoginMethod("http://45.32.110.240", "test", "test123QWE@AD"))
    parse = argparse.ArgumentParser(description="Check login user and password")
    parse.add_argument("--url", help="URL")
    parse.add_argument("--user", help="User")
    parse.add_argument("--password", help="Password")

    args = parse.parse_args()

    url = args.url
    user = args.user
    password = args.password

    if checkLoginMethod(url, user, password):
        print("User login success!")
    else:
        print("User login failed!")
