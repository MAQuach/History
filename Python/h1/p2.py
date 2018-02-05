#Michael Quach
##############################################################################
#Write all code for this problem in a file p2.py.
#1. The program consists of a main while loop (an infinite loop) in which the user is prompted to enter values for coefficients a, b, and c.
#Assume the user types valid float numbers from the terminal.
#The program converts the input to float type and then uses formula (1) above to compute solutions x1 and x2, as follows:
#a) if b2-4ac<0 then the solutions are complex numbers (i.e. not real) and the program displays
#the string "no real solutions”,
#b) if b2-4ac=0 then x1=x2 and the program displays: "one solution: " followed by the value x1.
#c) if b2-4ac>0 then the solutions are distinct and the program displays "two solutions: "
#followed by the values of x1 and x2.
#To keep the problem simple we can assume that the user never enters a value for coefficient a that is equal to 0.
#To stop the loop and to end the program, the user types the enf-of-file key – CTRL-Z on Windows
#(CTRL-D on Linux/Mac/Unix) – when expected to enter coefficient a for a new iteration.
##############################################################################
import pylab
import math
#NOTICE: Since you had us install Python via Anaconda, I couldn't figure out
#how to install the pylab module for IDLE, so I"m using Spyder from the 
#Anaconda package because it can access pylab.
coA = 0
print("To exit the program, enter 0 when asked for coefficient a.")
#I couldn't figure out how to use EOF as a condition, and every answer online
#just says to use some method or other.
while 1:
    coA=input("Please enter the value of the coefficient a: ")
    coA=float(coA)
    if coA == 0: break
    coB=input("Please enter the value of the coefficient b: ")
    coB=float(coB)
    coC=input("Please enter the value of the coefficient c: ")
    coC=float(coC)
    coefficient=(coB*coB)-(4*coA*coC)
    if coefficient<0:
        print("No real solutions.")
    elif coefficient==0:
        x1=-coB/(2*coA)
        print("One solution: ",x1)
    elif coefficient>0:
        x1=(-coB+math.sqrt(coefficient))/(2*coA)
        x2=(-coB-math.sqrt(coefficient))/(2*coA)
        print("Two solutions:", x1," and ",x2)

##############################################################################
#2. Within the main loop, after displaying the values of the real solutions (if any) the program must display the graphic of the quadratic function on the [-5, 5] domain.
#For that, use the pylab Python module. Within a nested while loop populate a list of floats in variable xs with 100 float numbers
#between -5 and +5 as shown in the lecture and append to a list ys the matching function values:
#   for each x in xs,
#       append in ys the value of expression a*x*x + b * x + c.
#(As an alternative to a loop, you could use the pylab.linspace() function to generate the x values.)
#Then, use the pylab.plot() function to generate the plot and the pylab.show() function to display the graphic figure.
#Make sure the function line is displayed with a blue line and dots.
##############################################################################

    xs=[]
    ys=[]
    x0=-5
    x1=+5
    x=x0
    n=100
    dx=(x1-x0)/n

    while x<=x1:
        xs.append(x)
        y=(coA*x*x)+(coB*x)+coC
        ys.append(y)
        x+=dx
    
    pylab.plot(xs, ys, "b.-")
    pylab.show()
