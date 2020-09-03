def binary_search(x, arr):
    low = 0
    high = len(arr) - 1

    while low <= high:
        mid = (high + low) // 2
        if arr[mid] == x:
            return mid
        elif arr[mid] > x:
            high = mid - 1
        else:
            low = mid + 1
    return -1


if __name__ == '__main__':
    arr = [2, 3, 6, 5, 7, 9, 10, 8]
    arr.sort()

    print(arr)

    print(binary_search(5, arr))
    print(binary_search(20, arr))
    print(binary_search(8, arr))

