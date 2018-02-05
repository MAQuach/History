#Michael Quach
##############################################################################
#Problem 3. Computing Change (includes 10 extra credit points)
#Write a program p3.py that computes the equivalent of a dollar amount in
#change using quarters, dimes, and pennies. No nickels are used for conversion.
#The program reads from the terminal the dollar amount in a loop while not
#end-of-file. Inside the loop it computes how many quarters, dimes, and pennies
#make up the original dollar amount and then displays the change. The program
#should terminate if the user types an invalid string.
##############################################################################
while 1:
    changed=input("Enter amount to exchange: ")
    changed=float(changed)
    if type(changed)!=float:
        break
    change=changed
    quarters=change//0.25
    change=change%0.25
    dimes=change//0.10
    change=change%0.10
    pennies=(change*100)
    coins=quarters+dimes+pennies
    print("$", changed," makes ", quarters, "quarters, ", dimes, "dimes, and "\
          , pennies, "pennies, totalling $",(quarters*0.25)+(dimes*0.10)+\
          (pennies/100), "across", coins, " coins.")
