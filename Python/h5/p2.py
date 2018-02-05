#Michael Quach
#Problem 2. Non-interactive Text Editing 
#A non-interactive text editor executes simple editing commands on a text file 
#using a programming interface (i.e. functions or object methods) in some 
#programming language, like Python. All commands take as input, at minimum, 
#the file name as a parameter, then perform their job (reading or modifying 
#the file), and end returning some results. For this problem we assume the 
#text files have the utf-8 encoding (the default in Python) and they are not 
#too large. Therefore, it’s OK to read the file entirely to memory, execute 
#the operations required, then overwrite the file with the modified file 
#content, as a string. This is not the only approach, but it’s the simpler one 
#and it works for smaller files. 
#Here are the editing commands, with the corresponding function signatures: 
def ed_read(filename, fro=0, to=-1): 
    '''#returns as a string the content of the 
    #file named filename, with file positions in the half-open range [from, to).
    #If to == -1, the content between from and the end of the file will be 
    #returned. If parameter to exceeds the file length, then the function 
    #raises exception ValueError with a corresponding error message. '''
    filename.seek(0,2)
    end = filename.tell()
    try:
        if(to > end):
            print("ValueError: Exceeding file size.")
            return -1
        if(to>0):
            filename.seek(fro)
            result = filename.read(to)
        elif(to==-1):
            filename.seek(0)
            result = filename.read
        return result
    except:
        raise ValueError("Read value exceeds file length.")

def ed_find(filename, search_str): 
    '''    #finds string search_str in the file named by filename and returns a list with 
    #index positions in the file text where the string search_str is located. 
    #E.g. it returns [4, 100] if the string was found at positions 4 and 100. 
    #It returns [] if the string was not found.'''
    result = []
    for line in filename.readline():
        if(search_str in line):
            for ii in line:
                if(search_str[0] == line[ii]):
                    yes = True
                    for jj in range(len(search_str)):
                        if(search_str[jj] != line[ii+jj]):
                            yes = False
                if(yes):
                    result.append(filename.seek()-len(search_str))
    
def ed_replace(filename, search_str, replace_with, occurrence=-1): 
    '''#replaces search_str in the file named by filename with string replace_with.  
    #If occurrence==-1, then it replaces ALL occurrences. 
    #If occurrence>=0, then it replaces only the occurrence with index  occurrence, 
    #where 0 means the first, 1 means the second, etc. 
    #If the occurrence argument exceeds the actual occurrence index in 
    #the file of that string, the function does not do the replacement. 
    #The function returns the number of times the string was replaced. '''
    locations = ed_find(filename, search_str)
    replacements = 0
    try:
        if(occurrence == -1):
            for ii in locations:
                for jj in range(len(replace_with)):
                    filename[locations[ii+jj]] = replace_with[jj]
                replacements+=1
        elif(occurrence >= 0):
            for jj in range(len(replace_with)):
                    filename[locations[occurrence+jj]] = replace_with[jj]
            replacements+=1
    except IndexError:
        raise IndexError
    return replacements


def ed_append(filename, string): 
    '''#appends string to the end of the file. If the file does not exist, 
    #a new file is created with the given file name. The function returns 
    #the number of characters written to the file. '''
    try:
        filename.read()
    except (FileNotFoundError, NameError):
        filename = open(filename, "w")
    
    filename.seek(0,2)
    try:
        filename.write(string)
    except PermissionError:
        raise PermissionError("Not allowed to edit file or create new file.")
    return len(string)
    
def ed_write(filename, pos_str_col):  
    '''#for each tuple (position, s) in collection pos_str_col (e.g. a list) 
    #this function writes to the file at position pos the string s. 
    #This function overwrites some of the existing file content. 
    #If any position parameter is invalid (< 0) or greater than the file 
    #contents size, the function does not change the file and raises 
    #ValueError with a proper error message. In case of no errors, the 
    #function returns the number of strings written to the file. Assume 
    #the strings to be written do not overlap. '''
    filename.seek(0,2)
    end = filename.tell()
    for ii in range(len(pos_str_col)):
        if(pos_str_col[ii][0] > end):
            raise ValueError("Attempted to exceed file size.")
    for ii in range(len(pos_str_col)):
        filename.seek(0, pos_str_col[ii][0])
        filename.write(pos_str_col[ii][1])
    return len(pos_str_col)
        
def ed_insert(filename, pos_str_col):  
    '''#for each tuple (position, s) in collection pos_str_col (e.g. a list) 
    #this function inserts into to the file content the string s at position pos. 
    #This function does not overwrite the existing file content, as seen in 
    #the examples below. If any position parameters is invalid (< 0) or greater 
    #than the original file content length, the function does not change the 
    #file at all and raises ValueError with a proper error message. In case of 
    #no errors, the function returns the number of strings inserted to the file.'''
    filename.seek(0,2)
    end = filename.tell()
    for ii in range(len(pos_str_col)):
        if(pos_str_col[ii][0] > end):
            raise ValueError("Attempted to exceed file size.")
    filename.seek(0,0)
    for ii in range(len(pos_str_col)):
        insert = filename.read(pos_str_col[ii][0])
        insert.append(pos_str_col[ii][1])
        insert.append(filename.read())
        filename.write(insert)
    return len(pos_str_col)

#For all the functions above, the file should not be changed in case of an 
#error. If an error related to file I/O (e.g. FileNotFoundError or IOError) 
#occurs in one of these functions, it should be passed to the caller. This 
#means that these functions should not catch (except:) file IO errors.
#
#Examples:
#fn = "file1.txt"    # assume this file does not exist yet. 
#ed_append(fn, "0123456789")    # this will create a new file 
#ed_append(fn, "0123456789")    # the file content is: 01234567890123456789
#
#print(ed_read(fn, 3, 9))    # prints 345678. Notice that the interval excludes index to (9) 
#print(ed_read(fn, 3))       # prints from 3 to the end of the file: 34567890123456789
#
#lst = ed_find(fn, "345") 
#print(lst) # prints [3, 13] print(ed_find(fn, "356"))   # prints []
#
#ed_replace(fn, "345", "ABCDE", 1)  # changes the file to 0123456789012ABCDE6789
#
## assume we reset the file content to 01234567890123456789  (not shown) 
#ed_replace(fn, "345", "ABCDE")  # changes the file to 012ABCDE6789012ABCDE6789      
#
## assume we reset the file content to 01234567890123456789 (not shown) 
## this function overwrites original content: 
#ed_write(fn, ((2, "ABC"), (10, "DEFG")))   # changes file to: 01ABC56789DEFG456789 
## this should work with lists as well: [(2, "ABC"), (10, "DEFG")]
#
## assume we reset the file content to 01234567890123456789 (not shown) 
#ed_write(fn, ((2, "ABC"), (30, "DEFG")))  # fails. raises ValueError("invalid position 30")
#
## assume we reset the file content to 01234567890123456789 (not shown) 
## this function inserts new text, without overwriting: 
#ed_insert(fn, ((2, "ABC"), (10, "DEFG"))) 
## changed file to: 01ABC23456789DEFG0123456789
#
#Here are your tasks for this problem: 
#    a) Implement in Python all functions listed on the previous page in file p2.py. 
#Write the contracts for each function in its docstring. Ensure precondition 
#errors are handled properly and ValueError is raised in case the precondition 
#is not met. All errors related to file I/O (e.g. FileNotFoundError or IOError) 
#should be passed to the caller. 
#    b) Write test functions for functions ed_write and ed_replace using the 
#testif() function we used for homework 3, listed in Appendix A.  These test 
#functions should be named test_x , where x is the name of the function 
#tested. E.g. test_ed_write() should use testif() to test ed_write(). 
#In general, this type of test functions are called unit tests as they 
#test just one function (or one method in a class). In Appendix B there 
#is a sample unit test for ed_append(). Use that as a template. 
#    c) Write a main() function where you show how to use all  ed_…. functions 
#written for part a).
#    d) EXTRA CREDIT for 5 points 
#Write a function ed_search(path, search_string) that searches for search_string 
#in all files in directory path and its immediate subdirectories using 
#the os.walk function. 
#The ed_search function must use the ed_find() function from part a). 
#ed_search must return the list of full (absolute) path names where 
#files in which search_string is found or the empty list [] if the string 
#is not found in any files. The ed_search function should not proceed 
#recursively to all subdirectories.
