#Michael Quach

#Problem 3. LeBron Worship 
#
#For this problem we will marvel at how glorious a basketball 
#player LeBron James is. Go to 
#http://www.basketball-reference.com/players/j/jamesle01.html, 
#and click on the “Share & More” menu, then click on the 
#“Get table as CSV (for Excel)” menu item. Copy-paste-save 
#the commaseparated-values table from the web page to a file 
#to be named lb-james.csv. The file should start with these 3 lines:
#    Season,Age,Tm,Lg,Pos,G,GS,MP,FG,FGA,FG%,3P,3PA,3P%,2P,2PA,2P%,
#    eFG%,FT,FTA,FT%,ORB,DRB,TRB,AST,STL,BLK,TOV,PF,PTS 2003-04,19,
#    CLE,NBA,SG,79,79,39.5,7.9,18.9,.417,0.8,2.7,.290,7.1,16.1,.438,
#    .438,4.4,5.8,.754,1.3,4.2,5.5,5.9,1.6,0.7,3.5,1.9,20.9 2004-05,
#    20,CLE,NBA,SF,80,80,42.4,9.9,21.1,.472,1.4,3.9,.351,8.6,17.2,
#    .499,.504,6.0,8.0,.750,1.4,6.0,7.4,7.2,2.2,0.7,3.3,1.8,27.2
#In case you wonder what the stats mean, the web page gives an 
#explanation for each column. Just hover the mouse on top of the header. 
#
#Write the code for this problem in a new file p3.py. 
def get_csv_data(f, string_pos_lst, sep):
#a) Write a function called get_csv_data() that takes these parameters: 
#    • f: an open file object in CSV format 
#    (similar to our lb-james.csv file), where the first line has 
#    only column headings, followed by lines with comma-separated data items, 
#    • string_pos_lst: a list with index positions (starting from 0) 
#    for columns that have a string format. For the lb-james.csv file, 
#    this list should be [0, 2, 3, 4]. All other columns are assumed 
#    to have a float format. Assume that this list is not sorted in any way. 
#    • sep: a string representing the column separator with default value “,” 
    data_lst = f.read().split(sep)
    for line in f:
        if line is not in string_pos_lst:
            
#The function get_csv_data returns a nested list we call here data_lst, as follows: 
#    • it reads the first line from file f (with the column headings) 
#    and adds to data_lst a list with the column heading strings, 
#    • after that first line, it reads file f line by line and parses 
#    each line based on the string_pos_lst parameter. All columns on a 
#    line are assumed to be floats if not specifically indicated in the 
#    string_pos_lst list. The function adds the list with parsed tokens 
#    (floats or/and strings) to the data_lst list. Lines with at least 
#    one parsing error are ignored. E.g. trying to call float(‘’) will 
#    raise ValueError; we skip this entire line and go to the next one. 
#    
#Error handling: check parameters for invalid values (e.g. sep==empty string). 
#It is acceptable for this function to throw/raise IndexError and errors 
#related to I/O failures. 
#Example. Here is how this function can be used: 
#    bb_file = open(“lb-james.csv”, “r”) 
#    bb_lst = get_csv_data(bb_file, [0, 2, 3, 4], “,”)
#(error handling is omitted here for brevity) 
#Element  bb_lst[0] should be a list with the column headings: 
#    [“Season”,”Age”,”Tm”, ……., “PTS”]. 
#Element  bb_lst[1] should be a list with column for line 1 data:
#    [“2003-04”,19.0,”CLE”,”NBA”,”SG”,79.0,79.0, …….., 1.9,20.9]. 
#    Notice the types of the elements: they are strings for column 
#    indices given in list [0, 2, 3, 4]or floats otherwise.
#    
#b) Write in file p3.py a function get_columns() that returns selected 
#columns as lists using as input argument a list returned by function  
#get_csv_data(). Function get_columns() takes as paramers: 
#    • data_lst: a list previously returned from a call to function get_csv_data() 
#    • cols_lst: a list with the headings of columns to be returned get_columns() 
#    returns a nested list having as elements a list for each column 
#    whose heading is indicated in parameter cols_lst. If cols_lst==[] 
#    then the function returns []. If a column heading does not exist 
#    in data_lst[0], then that column is ignored. This function is best 
#    illustrated with an example using the lb-james.csv file:
#bb_file = open(“lb-james.csv”, “r”) 
#james_lst = get_csv_data(bb_file, [0, 2, 3, 4])    # columns at indeces 0,2,3,4                                                    # have a string format selected_cols_lst = get_columns(james_lst, [“Season”,”Age”,”PTS”])
#The returned nested list selected_cols then has the following data: 
#    selected_cols_lst = [ [“2003-04”, “2004-05”, ………, “2016-17”],  ← the Season column as list
#                          [19.0, 20.0, …….., 32.0],                ← the Age column as list
#                          [20.9, 27.2, …….., 27.1] ]               ← the PTS column as list
#                         (…. means we omitted many elements)
#Important: in order to get credit for part b) do NOT use the functions 
#from the csv module or other module that parses text or CSV files.
#
#c) Now we get to LeBron. Let’s use these functions to show how consistent 
#James has been over the years. Use these two functions and the pylab 
#module to show on one pylab chart the evolution of James performance for 
#3-point field goal percentage, 2-point field goal percentage, and free throw 
#percentage. Make sure the axes and data lines are properly labeled 
#(pylab.xlabel, ylabel, legend, title, etc.) 
#Write the necessary code to create the chart in file p3.py.
