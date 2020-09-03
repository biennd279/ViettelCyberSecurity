cmake_minimum_required(VERSION 3.16.3)
project(mypasswd)

set(CMAKE_CXX_STANDARD 14)

set(CMAKE_CXX_FLAGS "${CMAKE_CXX_FLAGS} -lcrypt")
set(CMAKE_CXX_LINK_EXECUTABLE "${CMAKE_CXX_LINK_EXECUTABLE} -lcrypt")

add_executable(mypasswd main.cpp)
add_executable(checkpasswd checkpasswd.cpp)