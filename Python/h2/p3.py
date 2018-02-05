#Michael Quach
import pylab
import math
#Problem 3 Function Visualization
#Read in string fun_str [x as parameter], domain, and int ns
fun_str = input("Enter fun_str, using x as the parameter: ")
x0 = input("Enter beginning of domain, x0: ")
x1 = input("Enter end of domain, x1: ")
ns = input("Enter number of points: ")
x0, x1, ns = float(x0), float(x1), int(ns)
xs=[]
ys=[]
#Fill ys=[] with results of evaluating xs on fun_str expression
dx=(x1-x0)/ns
x=x0
while x<=x1:
    xs.append(x)
    y = eval(fun_str)
    ys.append(y)
    x+=dx
#Print table of xs and ys,
print("\tx\t\ty")
for counter in range(0,ns):
    print("{:10.2f}\t{:10.2f}".format(xs[counter],ys[counter]))
#counter=0
#while counter<=ns:
#    print("x=",xs[counter],"\ty=",ys[counter])
#    counter+=1
#Print graph of xs and ys
pylab.plot(xs, ys, "r.-")
pylab.title("Graph of the function")
pylab.xlabel("x-axis")
pylab.ylabel("y-axis")
pylab.show()