import argparse
from urllib.parse import urlparse

from tcplib.tcplib import *


def downloadMethod(url: str, path: str):
    url = urlparse(url)

    sock = createSocket(url.hostname, url.port or 80)

    msg = 'GET {path} HTTP/1.1\r\n' \
          'Host: {host}\r\n' \
          'Connection: close\r\n' \
          '\r\n' \
        .format(path=path,
                host=url.netloc)

    response = sendTcpMsg(sock, msg.encode())

    sock.close()

    return response


def downloadFile(url: str, path: str):
    response = downloadMethod(url, path)

    header = response.split(b"\r\n\r\n")[0].decode()
    image = response.split(b"\r\n\r\n")[1]

    status_line = header.split("\r\n")[0]
    status_code = status_line.split(" ")[1]

    if status_code == "301":
        return -1

    file_name = path.split("/")[-1]
    file = open(file_name, "w+b")
    file.write(image)

    file.close()
    return len(image)


if __name__ == '__main__':
    parse = argparse.ArgumentParser(description="Download file from website")
    parse.add_argument("--url", help="URL")
    parse.add_argument("--remote-file", help="file path")

    args = parse.parse_args()

    url = args.url
    path = args.remote_file

    file_size = downloadFile(url, path)

    if file_size == -1:
        print("Download failed")
    else:
        print("Size of image is: {size}".format(size=file_size))
