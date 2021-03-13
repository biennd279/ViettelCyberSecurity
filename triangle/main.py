import math


# points is a list of 3D points
# ie: [[2, 9, -15], [0, 33, -20], ...]
def GetArea(A, B, C):
  AB = (B[0] - A[0], B[1] - A[1], B[2] - A[2])
  AC = (C[0] - A[0], C[1] - A[1], C[2] - A[2])
  x1, y1, z1 = AB
  x2, y2, z2 = AC
  return 0.5 * math.sqrt((y2 * z1 - y1 * z2) ** 2 + (x1 * z2 - x2 * z1) ** 2 + (x1 * y2 - x2 * y1) ** 2)


def FindLargestTriangleArea(points):
    # return largest area
    print points
    A, B, C, _ = points
    return GetArea(A, B, C)



if __name__ == '__main__':

    # Reading space delimited points from stdin
    # and building list of 3D points
    points_data = '-21,59,-93 -4,91,-2 1,61,2, 0,44,1'
    points = []
    for point in points_data.split(' '):
        point_xyz = point.split(',')
        points.append([int(point_xyz[0]), int(point_xyz[1]), int(point_xyz[2])])

    # Compute Largest Triangle and Print Area rounded to nearest whole number
    area = FindLargestTriangleArea(points)
    print int(round(area))
