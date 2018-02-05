#Michael Quach
from turtle import *
import turtle
result = {}
#Problem 1. Recursive Functions
#a) Binary Tree.
def binary_tree(depth, length):
    '''Recursively draws a binary tree. Assumes that the turtle is pointing down on start.
    Returns the turtle to its starting position, but the board will obviously have the tree drawn on it.'''
    if(depth<=0):
        return
    #Drawing left (of turtle) branch
    left(60)
    forward(length)
    right(60)
    #Drawing branches of the left branch
    binary_tree(depth-1, length/2)
    #Going back to the starting point
    left(60)
    backward(length)
    #Drawing right (of turtle) branch
    right(120)
    forward(length)
    left(60)
    #Drawing branches of the right branch
    binary_tree(depth-1, length/2)
    #Going back to the starting point
    right(60)
    backward(length)
    left(60)
    #Done()

#Part b:#######################################################################
def power(x,n):
    '''Returns the value of x raised to the n power, computed with recursive
    divide-and-conquer. Equivalent to x**n. x and n must be numbers or support
    several standard numerical operators (e.g. '<=', '*', '%').'''
    if(n<=0):
        return 1
    elif(n%2 != 0):
        return x*power(x,(n-1)//2)*power(x,n//2)
    else:
        return power(x, n//2) * power(x, n//2)

def test_power():
    '''Tests power(). The tests object is initialized with a sample of pairs of values
    and then iterated through to test each value pair in power(). Uses the testif()
    function, which prints to the console. Result is compared to using the ** operator.'''
    #Initialize test object with a bunch of tests
    tests=[]
    for ii in range(10):
        for jj in range(10):
            tests.append((ii, jj))
    print("Test names are in format: Function ({x},{y})")
    for ii in range(len(tests)):
        testname = "power "+str(tests[ii])
        testif(power(tests[ii][0], tests[ii][1]) == tests[ii][0]**tests[ii][1], testname)

#Part c)  Memoized Slice Sums.#################################################
def slice_sum(lst, begin, end):
    '''Returns the sum of elements in lst, starting with position begin and ending at (excluding) end.
    begin and end parameters must be positive and less than the length of lst, or else an IndexError is raised.
    Result is compared to expression sum(lst[begin:end]).'''
    if(begin < 0 or begin > len(lst) or end < 0 or end > len(lst)):
        raise IndexError
    elif(begin >= end):
        return 0
    else:
        return lst[begin] + slice_sum(lst, begin+1, end)
    
def test_slice_sum():
    '''Tests slice_sum(). The tests object may be edited to contain any summable collections.
    This function attempts to iterate through every possible permutation of the collections given using testif().
    Note that testif() prints to console, so this function may clutter it.'''
    tests = [[1,2,3,4,5,6,7,8,9],
             [9,8,7,6,5,4,3,2,1],
             [4,87,8,2,5,4,8,2,5,100],
             [486,125,753,951,0,500,2,56,985,653,111,325,0,9]]
    begin, end = 0,0
    print("Test names are in format: Function {ii}.{begin}.{end}")
    for ii in range(len(tests)):
        for begin in range(len(tests[ii])):
            for end in range(len(tests[ii])):
                testname = "slice_sum "+str(ii)+"."+str(begin)+"."+str(end)
                testif(slice_sum(tests[ii], begin, end) == sum(tests[ii][begin:end]), testname)

def slice_sum_m(lst, begin, end):
    global result
    if(begin < 0 or begin > len(lst) or end < 0 or end > len(lst)):
        raise IndexError
    if(begin == end):
        return 0
    else:
        result[(begin, end)] = lst[begin] + slice_sum_m(lst, begin+1, end)
        return result[(begin, end)]
    return result

def test_slice_sum_m():
    '''Tests slice_sum_m(). The tests object may be edited to contain any summable collections.
    This function attempts to iterate through every possible permutation of the collections given using testif(),
    which prints to console.'''
    tests = [[1,2,3,4,5,6,7,8,9],
             [9,8,7,6,5,4,3,2,1],
             [4,87,8,2,5,4,8,2,5,100],
             [486,125,753,951,0,500,2,56,985,653,111,325,0,9]]
    begin, end = 0,0
    for ii in range(len(tests)):
        for begin in range(len(tests[ii])):
            for end in range(len(tests[ii])):
                testif(slice_sum_m(tests[ii], begin, end) == sum(tests[ii][begin:end]))

def testif(b, testname='', msgOK='', msgFailed=''):
    '''Function used for testing.
    param b: boolean, normally a tested condition: true if passed, false otherwise
    param testname: the test name
    param msgOK: string to be printed if param b==True (test condition true
    param msgFailed: string to be printed if param b==False (test condition flae)
    returns b'''
    if b:
        print("Success:", str(testname), ";", msgOK)
    else:
        print("Failed:", str(testname), ";", msgFailed)
    return b