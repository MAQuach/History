#Michael Quach
import math
#Read input “limit”
limit=input("Hi. I calculate Pythagorean Triples. \
How far do you want me to look for them?\nEnter an integer: ")
limit=int(limit)
print("a\tb\tc")
a,b,c=1,1,1
while a<limit:
    while b<limit:
        c=((a*a)+(b*b))
        #d will serve as a temporary sqrt(c), saved to compare later
        d=math.sqrt(c)
        d=int(d)
        #Now that d is an int, it should be equal to sqrt(c)
        #if sqrt(c) is an int (even if it's technically a float)
        if d<limit and math.sqrt(c)==d:
            print(a,"\t",b,"\t",d)
        b+=1
    a+=1
    b=1