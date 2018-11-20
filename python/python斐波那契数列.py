Python 3.6.7 (v3.6.7:6ec5cf24b7, Oct 20 2018, 13:35:33) [MSC v.1900 64 bit (AMD64)] on win32
Type "help", "copyright", "credits" or "license()" for more information.
>>> a=1
>>> n=0
>>> while a<1000:
	print(a)
	n,a=a,n+a

	
1
1
2
3
5
8
13
21
34
55
89
144
233
377
610
987
>>> a=0
>>> b=1
>>> while b<1000:
	print(b,end=',')
	a,b=b,a+b

	
1,1,2,3,5,8,13,21,34,55,89,144,233,377,610,987,
>>> def function(n):
	if n==1 or n==2:
		rerurn 1
		
SyntaxError: invalid syntax
>>> def func(n):
	if n==1 or n==2:
		return 1
	else:
		return func(n-1)+func(n-2)

	
>>> res=func(20)
>>> print(rec)
Traceback (most recent call last):
  File "<pyshell#23>", line 1, in <module>
    print(rec)
NameError: name 'rec' is not defined
>>> print(res)
6765
>>> name[]
SyntaxError: invalid syntax
>>> def fun(n):
	if n==1 or n==2:
		return 1
	else:
		return fun(n-1)+fun(n-2)

	
>>> print(fun())
Traceback (most recent call last):
  File "<pyshell#32>", line 1, in <module>
    print(fun())
TypeError: fun() missing 1 required positional argument: 'n'
>>> print(fun(5))
5
>>> 
>>> 
>>> 
>>> 
>>> 
