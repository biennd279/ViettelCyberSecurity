import socket as sk
import re
from tcplib import parseTcpMsg
from tcplib import sendTcpMsg
from tcplib import createSocket
from urllib.parse import urlparse


def getMethod(url: str):
    url = urlparse(url)
    sock = createSocket(url.hostname, url.port or 80)
    
    msg = 'GET {path} HTTP/1.1\r\n' \
          'Host: {host}\r\n' \
          'Connection: close\r\n' \
          '\r\n' \
        .format(path=url.path or "/",
                host=url.netloc)
    
    response = sendTcpMsg(sock, msg.encode())

    sock.close()

    return parseTcpMsg(response.decode())


def getTitle(source: str):
    regex = r"\<title\>([\S\s]+)\<\/title\>"
    return re.search(regex, source).group(1)


if __name__ == '__main__':
    header, body = getMethod("http://45.32.110.240/")
    print(getTitle(body))
