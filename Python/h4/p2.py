#Michael Quach
#Problem 2. Polynomials 
import pylab
#Design and implement (in file p2.py) a class called Poly for representing 
#and operating with polynomials.
class Poly:
    coeffs=[]
#    a) The Poly class must support the following operations, illustrated with examples below: 
#-- Initialization, with the constructor taking an iterable (like a list [ ]) 
#that generates the coefficients, starting with a0. The coefficients are floats 
#or ints, but the constructor must convert them to type float. The degree of the 
#polynomial is given by the length of the sequence of the sequence. 
    def __init__(self,coeffs):
        index=0
        while(index<len(coeffs)):
            self.coeffs.append(float(coeffs[index]))
            index+=1
#-- Conversion to string (__str__). Skip terms akXk with coefficient ak=0. 
#Use the default number of decimals for floats. 
    def __str__(self):
        nomial = ''
        index=0
        while(index<len(self.coeffs)):
            nomial =  str(self.coeffs[index]) + 'x^' + str(index) + ' + ' + nomial
            index+=1
        nomial = nomial + '0'
        return nomial
#-- Representation, for printing at the terminal (__repr__). 
    def __repr__(self):
        return self.__str__()
#-- Indexing. This operation takes parameter k and returns the coefficient 
#ak if 0<=k<=n or throws ValueError otherwise. 
#If p is a Poly object p[k] returns ak. (__getitem__) 
    def __getitem__(self, k):
        if 0<=k<=len(self.coeffs):
            return self.coeffs[k]
        else:
            print("ValueError:",k,"is not within the bounds of this polynomial.")
#-- Addition with another Poly object (__add__). 
    def __add__(self, other):
        result = []
        index=0
        while(index<len(self.coeffs)):
            result.append(self.coeffs[index]+other.coeffs[index])
            index+=1
        return result
#-- Multiplication with another Poly object and with a float or an int. 
#(__mul__ and __rmul__)
    def __mul__(self, other):
        if(type(self)!=type(other)):
            result=[]
            index=0
            while(index<len(self.coeffs)):
                result.append(self.coeffs[index] * other)
                index+=1
            return result
        else:
            result=[]
            selfi=0
            while(selfi<len(self.coeffs)):
                otheri=0
                while(otheri<len(self.coeffs)):
                    try:
                        result[selfi+otheri] += self.coeffs[selfi] * other.coeffs[otheri]
                    except IndexError:
                        start = len(result)
                        finish = selfi+otheri
                        while (start<finish):
                            result.append(0)
                            start+=1
                        result.append(self.coeffs[selfi] * other.coeffs[otheri])
                    otheri+=1
                selfi+=1
            return result
                    
    def __rmul__(self,other):
        return other*self
#-- Testing for equality (__eq__, __ne__). Two polynomials are equal if their 
#coefficients are respectively equal. Equal polynomials must be of the same degree. 
    def __eq__(self, other):
        if(len(self.coeffs)==len(other.coeffs)):
            index=0
            while(index<len(self.coeffs)):
                if(self.coeffs[index] != other.coeffs[index]):
                    return False
                index+=1
            return True
        else:
            return False
        
    def __ne__(self, other):
        return not self.__eq__(other)
#-- Evaluation of the polynomial for a given value x for variable X. The method 
#is called eval : ◦ if x is an int or float then p.eval(x) returns the value of expression
######Sigma(k=0 to n, a_k*x^k)######
#◦ if x is a sequence of elements x0, x1,… (an iterable, such as a tuple or a list),  
#then p.eval(x) returns a list with the matching elements 
#[self.eval(x0), self.eval(x1), ….  ].  Use a list comprehension  for this evaluation.
    def eval(self, other):
        if (type(other)==int or type(other)==float):
            result=0.0
            index=0
            while(index<len(self.coeffs)):
                result += self.coeffs[index]*(other**index)
                index+=1
            return result
        else:
#            result=[]
#            for index in other:
#                result.append(self.eval(other[index]))
#            return result
            return [self.eval(other[index-1]) for index in other] 
    
    def graphit(self, xseq):
        yseq=self.eval(xseq)
        pylab.plot(xseq, yseq, 'r.-')
        pylab.title('Graph of a Polynomial')
        pylab.xlabel('x')
        pylab.ylabel('y')
        pylab.show()
#b) Write in file p2.py a function called test_poly that tests all operations 
#and methods from part a). Use the function testif() from Homework 3 or something similar.
#    
def test_poly(nomial):
    print('nomial:',nomial)
    print('nomial.__str__:',nomial.__str__)
    print('nomial.__repr__:',nomial.__repr__)
    print('nomial[3]:',nomial[3])
    print('nomial+nomial:',nomial+nomial)
    print('nomial*nomial:',nomial*nomial)
    print('nomial*11:',nomial*11)
    print('nomial==nomial:',nomial==nomial)
    print('nomial!=nomial:',nomial!=nomial)
    print('nomial.eval(5):',nomial.eval(5))
    print('nomial.eval([1,2,3,4]):',nomial.eval([1,2,3,4]))
    nomial.graphit([i for i in range(-50,51)])
#Extra credit: 2 points c) add a method to class Poly called graphit(xseq) 
#that takes a sequence of floats in parameter xseq (such as a list), 
#evaluates with method eval() the polynomial in the xseq points, and  
#then plots the function nicely using the pylab or matplotlib plot() function. 
#Display the coordinate axes and proper labels. Use sufficient points in 
#xseq to make the chart smooth. Include a screenshot of the plot in file h4.doc.

polymer = Poly([0.5,1,1.5,2,2.5,3])
test_poly(polymer)