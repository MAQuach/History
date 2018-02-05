#Michael Quach
#int n is length of duped substring to find in string s
def find_dup_str(s, n):
    left=0
    right=n
    i=0
    
    if(n>len(s)):
        return ""
#For all characters in string s:
    while(i<len(s)):
        i+=1
#If a duplicate character is found:
        if(s[left:right]==s[left+i:right+i]):
            #print ("Substring", s[left:right], "found at positions",\
            #       left, "and", left+i, ".")
            return s[left:right]
#if i reaches the end of the string but we haven't compared every substring yet
        if(i==(len(s)-1) and right<(len(s)-1)):
            #reset to the beginning of the string
            i=1
            #but increment the chosen substring
            left+=1
            right+=1
    return ""
            
def find_max_dup(s):
    for i in range(0,len(s)):
        temp=find_dup_str(s,i)
        if(temp!=""):
            answer=temp
    return answer
            
test=input("Enter 1 to test find_dup_str() or 2 to test find_max_dup(). ")
if(test=='1'):
    s=input("Enter a string: ")
    n=input("Enter the length of the substring to find: ")
    n=int(n)
    print ("Substring found:",find_dup_str(s,n))
if(test=='2'):
    s=input("Enter a string: ")
    print ("Substring found:",find_max_dup(s))
