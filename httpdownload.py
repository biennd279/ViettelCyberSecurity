import socket as sk
from urllib.parse import urlparse
from tcplib import parseTcpMsg
from tcplib import createSocket
from tcplib import sendTcpMsg


def downloadMethod(url: str):
    url = urlparse(url)
    
    sock = createSocket(url.hostname, url.port or 80)

    msg = 'GET {path} HTTP/1.1\r\n' \
          'Host: {host}\r\n' \
          'Connection: close\r\n' \
          '\r\n' \
        .format(path=url.path,
                host=url.netloc)

    response = sendTcpMsg(sock, msg.encode())

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
