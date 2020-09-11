import socket as sk
from urllib.parse import urlparse
from tcplib import parseTCPMsg


def downloadMethod(url: str):
    url = urlparse(url)
    sock = sk.socket(sk.AF_INET, sk.SOCK_STREAM)
    sock.connect((url.hostname, url.port or 80))
    msg = 'GET {path} HTTP/1.1\r\n' \
          'Host: {host}\r\n' \
          'Connection: close\r\n' \
          '\r\n' \
        .format(path=url.path,
                host=url.netloc)

    sock.sendall(msg.encode())

    response = b''
    while True:
        chunk = sock.recv(4096)
        if not chunk:
            break
        response += chunk
    sock.close()

    return response.split(b"\r\n\r\n")[1]


def downloadImage(url:str):
    image = downloadMethod(url)

    fileName = url.split("/")[-1]
    file = open(fileName, "w+b")
    file.write(image)

    file.close()


if __name__ == '__main__':
    downloadImage("http://45.32.110.240/wp-content/uploads/2020/09/okela-21.jpg")
