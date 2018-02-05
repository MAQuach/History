#Michael Quach
#Problem 3. Functional Code with Random Number Sequences
import random
import itertools
def gen_rndtup(n):
    '''Generates a random two-tuple where each element is less than n.'''
    a,b=0,0
    while(n):
        a, b = random.randint(1,n), random.randint(1,n)
        yield (a,b)
#Write a generator gen_rndtup(n) that creates an infinite sequence of tuples 
#(a, b) where a and b are random integers, with 0 < a,b < n. If n == 7, then 
#a and b could be the numbers on a pair of dice. Use the random module. 
#lambda
#islice()
#filter
def partA():
    n=7
    itera = itertools.islice(iter(filter(lambda a,b,n: a+b >= n//2, gen_rndtup(n))), 10)
    for ii in range(10):
        print(next(itera))
#a) Write code in file p3.py that uses lambda expressions, the itertools.islice 
#function (https://docs.python.org/3/library/itertools.html#itertools.islice), 
#and the filter function to display the first 10 generated tuples (a, b) from 
#gen_rndtup(7) that have a + b >= n // 2.
#Example: with n==7 the output could be: (4,1), (2,6), (6,6),(3,5),...

def generatorB():
    a,b=0,0
    while True:
        a,b = random.randint(1,14), random.randint(1,14)
        yield (a,b)
        
def filterB(num, seq):
    n=7
    while num:
        a,b = next(seq)
        if(a+b >= n//2):
            num-=1
            yield (a,b)
        
def partB(num):
    seq = (seq for i in filterB(num, generatorB()))
    for ii in seq:
        print(next(seq))
#b) Write code using generator expressions and one for loop that displays the 
#first 10 random integer tuples (a, b), with 0<a,b<n, where a + b >= n // 2 
#and n being a positive integer local variable initialized with value 7. 
#Do not use the gen_rndtup(n) generator from part a). You may use other functions.
#Place all the code in file p3.py and paste that in h6.doc.
#
#Extra credit part, for 5 points:
#c) Use lambda expressions, map(), the itertools.islice, functools.reduce(), 
#and the filter function to display the sum of first 10 generated tuples 
#(a, b) that have sum a + b >= n // 2.
#The sum of tuples is done component-wise for each tuple element. 
#E.g. if the sequence filtered is (4,1), (2,6), (6,6),(3,5), then the sum of 
#these tuples that is displayed is (4+2+6+3, 1+6+6+5) = (15, 18).