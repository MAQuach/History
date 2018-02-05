#Michael Quach

#Problem 1. Salary Computation
#Write a Python program called p1.py that computes the salary for a worker that is paid weekly.
#The p1 program starts by displaying some instructions to the user.
#Then it reads from the terminal (in this order!) the number of hours worked in a week (variable
#hours_worked, to convert to float), the hourly salary (rate_per_hour, float), and whether the
#worker has received a bonus (variable yes_no). If yes_no is ‘y’, then the program reads the
#bonus (in variable bonus, also converted to a float).
#The program computes the total salary as the sum of the overtime salary, the non-overtime
#salary, and the bonus. At the end, the program displays the total salary and the overtime pay.
#Any hours worked in a week above 40 will be paid with a salary rate that is 1.5 times the regular hourly rate.

print ("This program determines the weekly salary for an employee.")
print ("Salary = hours*rate + overtime + bonus")
print ("Overtime is 1.5*rate for any hours beyond 40.")
hours=input("Enter the number of hours worked this week: ")
hours=float(hours)
rates=input("Enter the salary rate per hour (do not include the '$' sign): ")
rate=float(rates)
bonus=0
#get bonus amount, if any
bonustr=input("Did the worker get a bonus ? (y/n) ")
if bonustr=='y':
    bonus=input("How much was the bonus?")
    bonus=float(bonus)
#Calculation if there was overtime
if hours>40:
    overtime=(hours-40)*(rate*1.5)
    print("The worker has earned $", overtime+(40*rate)+bonus, "($",overtime," overtime).")
#Calculation if there was no overtime
elif hours<=40:
    print("The worker has earned $", (hours*rate)+bonus, " with no overtime.")
