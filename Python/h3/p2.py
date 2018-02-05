#Michael Quach
import math
#Problem 2. Pythagorean Numbers Revisited
#Write a function named compute_Pythagoreans in file p2.py 
#that takes one positive int argument n and returns a list 
#with tuples (a,b,c), with 0<a,b,c<=n, such that a2+b2=c2. 
#The function MUST use one list comprehension and no loops, 
#or no credit is given for the solution. 
#
#The function should also use proper error checking and 
#return an empty list if the input parameter is invalid.

def compute_Pythagoreans(n):
    try:
        limit=int(n)
    except:
        print("Error: input must be a positive non-zero integer. Terminating.")
        return []
    
    a,b,c=1,1,1
    r=[(a,b,c) for a in range(limit) for b in range(limit) for c in range(limit)\
       if c==math.sqrt((a*a)+(b*b))]
    return r