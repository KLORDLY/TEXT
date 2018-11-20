Python 3.6.7 (v3.6.7:6ec5cf24b7, Oct 20 2018, 13:35:33) [MSC v.1900 64 bit (AMD64)] on win32
Type "help", "copyright", "credits" or "license()" for more information.
>>>  a = [i**3+j**3+k**3 for i in range(1, 10) for j in range(0, 10) for k in range(0, 10) if i*100+j*10+k == i**3+j**3+k**3]
SyntaxError: unexpected indent
>>> a= [i**3+j**3+k**3 for i in range(1, 10) for j in range(0, 10) for k in range(0, 10) if i*100+j*10+k == i**3+j**3+k**3]
>>> print(a)
[153, 370, 371, 407]
>>> 
