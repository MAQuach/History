#Michael Quach
#Problem 3. HR Matters 
#
#a) Design and implement in a file p3.py a class hierarchy for employees 
#in a startup company. The base class is Employee. This has subclasses 
#Manager, Engineer. Class Manager has a subclass called CEO. 
class Employee:
#Each employee has these: 
#-- Data attributes: 
#    name (string), 
    __name=''
#    base salary (float), 
    __salary=0.0
#    phone number (string). 
#    Make these private attributes (__ prefix). 
    __phone=''
#-- Constructor taking and saving as attributes name, phone number, 
#and base salary. (Ensure proper call chain for superclass constructors. ) 
    def __init__(self, name, salary, phone):
        self.__name=name
        self.__salary=salary
        self.__phone=phone
#-- Methods: accessors for the name and the phone number and a method 
#called salary_total() that returns the total salary, including any 
#extra benefits that subclasses might have. 
    def getname(self):
        return self.__name
    def getphone(self):
        return self.__phone
    def salary_total(self):
        return self.__salary
#A method (called a mutator) that updates the base salary. 
    def setsalary(self, salary):
        self.__salary=salary
#-- The __str__ method to generate a string representing the object. 
#E.g. “Manager(“Sophia Loren”,”561-2977777”, 100000). 
    def __str__(self):
        return str('Employee("'+self.__name+'","'+self.__phone+'",'+str(self.__salary)+')')
#-- The __repr__ method to generate the official string representation of the object. 
    def __repr__(self):
        return self.__str__()
         
#
#An Engineer object does not have anything in addition to what an Employee has. 
class Engineer(Employee):
    def __init__(self, name, salary, phone):
        self.__name=name
        self.__salary=salary
        self.__phone=phone
    def __str__(self):
        return str('Engineer("'+self.__name+'","'+self.__phone+'",'+str(self.__salary)+')')
    def __repr__(self):
        return self.__str__()
#A Manager has in addition to Employee a bonus (float). 
#    Its total salary is the base salary + bonus. 
class Manager(Employee):
    __bonus = 0.0
    def __init__(self, name, salary, phone):
        self.__name=name
        self.__salary=salary
        self.__phone=phone
    def salary_total(self):
        return self.salary_total()+self.__bonus
    def __str__(self):
        return str('Manager("'+self.__name+'","'+self.__phone+'",'+str(self.__salary)+')')
    def __repr__(self):
        return self.__str__()
#A CEO has in addition (to a Manager) stock options (float). 
#    Its total salary is the base salary + bonus + stock options. 
#    (in the real world stock options are never added to the salary, though) 
class CEO(Manager):
    __stock = 0.0
    def __init__(self, name, salary, phone):
        self.__name=name
        self.__salary=salary
        self.__phone=phone
    def salary_total(self):
        return self.salary_total()+self.__stock
    def __str__(self):
        return str('CEO("'+self.__name+'","'+self.__phone+'",'+str(self.__salary)+')')
    def __repr__(self):
        return self.__str__()
#The  salary_total method must be overridden in subclasses to compute the total 
#salary as described above. It should NOT access the superclass base salary 
#attribute, but it should use the salary_total() method provided by the 
#base class or superclass.
#
def print_staff(employed):
    item=0
    while(item<len(employed)):
        print(str(employed[item]))
        item+=1
#b) Write a function print_staff() that takes a sequence (e.g. a list) of 
#employee objects (incl. subclass instances) and prints their name, phone#, 
#and total salary, with one object per line. Write a main() method in file p3.py 
#that demonstrates the classes described above. Among other code, create in main() 
#several instances of each class in the employee hierarchy and add them to a list, 
#then call  print_staff() on that list. (if everything works correctly, this is an 
#illustration of polymorphism) 

Jake = Employee('Jake',10.00,'123456789')
Jake2 = Employee('Jakey',10.01,'012345678')
Josh = Employee('Josh',11,'1293485760')
Bob = Engineer('Bob', 15, '9191919191')
Sallary = Manager('Sallary',100,'9549549549')
Bill_Gates = CEO('Bill Gates',1000001,'1101000110')

emp = [Jake,Jake2,Josh,Bob,Sallary,Bill_Gates]
print_staff(emp)