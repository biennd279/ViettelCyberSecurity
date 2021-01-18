import base64
import hashlib
import urllib.parse


def getBase64(session: str):
    return base64.decodebytes(session.encode())


def getXor(s1: str, s2: str):
    return ''.join(chr(ord(a) ^ ord(b)) for a, b in zip(s1, s2))


def cipher(plaintext: str, key: str):
    plaintext = plaintext.encode()
    key = key.encode()
    len_key = len(key)
    result = []
    for i in range(len(plaintext)):
        result.append(plaintext[i] ^ key[i % len_key])
    return bytes(result)


def findKey(session: str, username: str, base_len: int):
    base64Session = getBase64(session).decode()
    for i in range(0, len(base64Session) - base_len):
        segment = base64Session[i:i + base_len]
        xorResult = getXor(segment, username[:base_len])
        reversed_text = cipher(base64Session, xorResult)
        if reversed_text.find(username.encode()) != -1:
            print(xorResult, reversed_text)


def genCookie():
    cookies = open('cookies.txt', 'w')
    for id in range(200, 300):
        key = 'tH1siSS3CrEtk3Y'
        plaintext = b'O:14:"App\\Model\\User":5:{s:2:"id";' + \
                    f's:{len(str(id))}:"{id}"'.encode() + \
                    b';s:8:"username";s:5:"admin";s:8:"password";b:1;s:5:"email";b:1;s:4:"name";s:5:"admin";}'
        base64Value = base64.encodebytes(cipher(plaintext.decode(), key)).decode()
        base64Value = "".join(base64Value.split("\n"))
        cookies.write(base64Value + '\n')
    cookies.close()


# if __name__ == '__main__':
#     session = "HEQZQnxeYhVtdm0RdnIWCWJ9KWducCRlfzR2eGc+YERLRB9QOxYuIEhWEHwRQCM3VFUGQlBTCUtJBkhJRwxVBwYHC0I/BSEgRFJTJ1JAIzdUVQZCUFMJS0kGSElHDFUHBgcLQj8FISBEUlMnUgNudEJHRRkTcSdmbDh7aW8jay8pOT5rGzsNDnB9Zgd6bxF0SA=="
#     username = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
#     print(findKey(session, username, 32))

if __name__ == '__main__':
    key = 'gfj#^d@A%32F3!BV54g#12h*(g)(&m4f'
    plaintext = '{"sa":"THE_WEST_WIND_BLOWS_PAST","username":"admin","ws":"COLD_RAIN_IN_THE_MOUNTAINS"}'
    base64Value = base64.encodebytes(cipher(plaintext=plaintext, key=key)).decode()
    base64Value = ''.join(base64Value.strip('\n'))
    print(base64Value)
    print(hashlib.md5(plaintext.encode()).hexdigest())

# if __name__ == '__main__':
#     key = "tH1siSS3CrEtk3Y"
#     plaintext = "O3IAR1NxEkMzLggbD1Y1KB1CFhtxaQZ5CTZOWQl7HSwTSBppYAlhRXdDSQgqTnALURwgNkEtEygRSQgqTnwLUQs6Nl1hSTZOUwl7BClCAB48IVdhSTZOXwNjViwFFls1ZQN7RnRCXwphRHkJQgxjN1d3ECNGW1I9ESkHR1o1MQN3QCdWUEBjQXITFgQyOl9hSTZOXwl7FiFUHUtoIAl3SGcaCl48VnNCSV1pcVEqFytWUE4="
#     print(cipher(getBase64(plaintext).decode(), key))


# if __name__ == '__main__':
#     genCookie()
