#Michael Quach
import classes
#(1)  Print “Hello World” 
print("Hello World")
#(2)  Save your age to a variable called “age” 
age=22.4
#(3)  Print “Hello World, I’m (age variable) today.” 
print("Hello World, I'm ", age," today.")
#(4)  Print “hello world” in all upper case using a python function to alter it 
print("hello world".upper())
#(5)  Save any decimal in a variable called a. 
a=1.618
#(6)  Cast a into an int and save it as b. 
b=int(a)
#(7)  Cast a into a string and save it as c. 
c=str(a)
#(8)  Print each variable and its type. 
print(type(a)," a is ", a,".\t",type(b)," b is ",b,".\t",type(c)," c is ",c)
#(9)  Create a tuple of your favorite things to eat and print it. 
thing1, thing2 = "meat", "vegetables"
print(thing1, thing2)
#(10) Create a dictionary named ‘classes’ with the name of the classes 
#     you are taking as the keys and the professors names as the values. 
myClasses = {'Object-Oriented Design': 'Fernandez',
           'Principles of Software Engineering': 'Bullard',
           'Programming Languages': 'Huang',
           'Computer Operating Systems': 'Furht',
           'Python Programming': 'Cardei'}
#(11) Print the dictionary and tuple. 
for j, k in myClasses.items():
    print(j, k)
#(12) Create a list called “whole” and put every number in it from 1 - 100 
whole=[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, \
       21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, \
       41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, \
       61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, \
       81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100]
#(13) Create 4 empty lists called ‘div2’, ‘div3’, ‘div4’, and ‘div5’ 
div2,div3,div4,div5=[],[],[],[]
#(14) Create a loop that examines each number from 1 to 100 and: 
for num in whole:
#    (a)  If it is divisible by 2, put it in div2 
    if(num%2==0):
        div2.append(num)
#    (b)  If it is divisible by 3, put it in div3 
    if(num%3==0):
        div3.append(num)
#    (c)  If it is divisible by 4, put it in div4 
    if(num%4==0):
        div4.append(num)
#    (d)  If it is divisible by 5, put it in div5 
    if(num%5==0):
        div5.append(num)
#(15) Print all 5 of these lists 
print(whole,"\n",div2,"\n",div3,"\n",div4,"\n",div5)
#(16) Create a new list called “divOver5” 
divOver5=[]
#(17) Create a new loop that goes through each number 1 through 100 
for num in range(1,101):
#     and appends it to divOver5 if it is NOT IN div2 or div3 or div4 or div5 
    if(num%2!=0 and num%3!=0 and num%4!=0 and num%5!=0):
        divOver5.append(num)
#     (a)  You must use logical operators here. 
#(18) Print divOver5 
print(divOver5)
#(19) Create a function called exp3 that takes an int x, raises it to the third power.  
def exp3(x):
    x=x*x*x
#     Create a string in the function that says “x^3 = “ and concatenate x 
#     onto the end of the string.  Now return the string from the function.
    redundantString="x^3 = " + str(x)
    return redundantString
#     Call the function exp3 and print what it returns. 
print(exp3(20))
#(20) Iterate through the classes dictionary and print the keys 
for j, k in myClasses.items():
    print(j)
#(21) Iterate through the classes dictionary and print the values 
for j, k in myClasses.items():
    print(k)
#Extra Points:   Create a class called Student that has the properties:   
class Student:
#    name (holds student name)  
    name=''
#    age (holds student age)  
    age=0
#    birthmonth (hold students birthmonth)    
    birthmonth=''
#    
#    A count variable exists that is set to 0 (see lecture) 
#    and upon each call to the class this variable increments 
# 
    count=0
    def __init__(self, name, age, birthmonth):
        self.name=name
        self.age=age
        self.birthmonth=birthmonth
        Student.count+=1
# 2 functions in the class:  
#    displayName which returns the name of the student and 
    def displayName(self):
        return self.name
#    displayBirthmonth which returns the birth month of the student 
    def displayBirthmonth(self):
        return self.birthmonth
# Now create 3 students, use whatever data you want.    
stu1 = classes.Student('Nikola Tesla',86,'July')
stu2 = classes.Student('Dennis Ritchie',70,'September')
stu3 = classes.Student('Shihong Huang',30,'January')
#Call displayName() on student1  
stu1.displayName()
#Call displayBirthmonth() on student2  
stu2.displayBirthmonth()
#print the student count
print(classes.Student.count)