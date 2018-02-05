#Michael Quach
import numpy
import pandas
#(1)  Move the show_results.txt file from Canvas into your project directory. 
#(2)  Create 3 lists, one for states, one for shows, and one for viewers. 
states, shows, viewers = [],[],[]
#(3)  Injest data from text file and put it into a NumPy array (show_results.txt)  
#    Itll look like a nested list.   
#    [ [‘Oregon’, ‘Once Upon a Time’, ‘4075’] [...] …] 
statsArray = numpy.genfromtxt('show_results.txt',dtype='str',delimiter=",")
#(4)  Print the raw data 
print(statsArray)
#(5)  Take the data from the NumPy array and sort it by state, show and viewers,
#    putting each into the appropriate lists you defined earlier.
#    (so now you have 3 lists, one with states, one with shows and
#    one with viewer counts.)  No duplicates in the states and shows.
#    Duplicates can and should exist in the viewers.
#    So the states list will look like this:
#    ['Washington', 'Nevada', 'Idaho', 'California', 'Oregon']
n=0
while(n<statsArray.shape[0]):
    states.append(statsArray[n][0])
    shows.append(statsArray[n][1])
    viewers.append(statsArray[n][2])
    n+=1
#(6)  Print these unsorted lists 
print("PRINTING STATES ARRAY:\n",states,"\nPRINTING SHOWS ARRAY:\n",shows,\
      "\nPRINTING VIEWERS ARRAY:\n",viewers,"\n")
#(7)  Convert all 3 lists into NumPy arrays 
states = numpy.array(states)
shows = numpy.array(shows)
viewers = numpy.array(viewers)
#(8)  print new NumPy Arrays 
states = numpy.unique(states)
shows = numpy.unique(shows)
print("PRINTING STATES ARRAY:\n",states,"\nPRINTING SHOWS ARRAY:\n",shows,\
      "\nPRINTING VIEWERS ARRAY:\n",viewers,"\n")
#(9)  Sort the States and Shows arrays  Now your States array will look like:  
#    ['California', 'Idaho', 'Nevada', 'Oregon', 'Washington'] 
#(10) Convert the Viewers array from STRINGS into INTS 
viewers = viewers.astype(int)
#(11) Sum up viewers list into one variable (you can do this in one line) 
total = sum(viewers)
#(12) Print: Sorted arrays (states and shows), viewers list (as ints), 
#    and the variable that is the sum of the viewers list. 
print("PRINTING STATES ARRAY:\n",states,"\nPRINTING SHOWS ARRAY:\n",shows,\
      "\nPRINTING VIEWERS ARRAY:\n",viewers,"\nTOTAL =",total)
#(13) Create 2 DataFrames: 
#    (a) show_raw_stats: index = numpy sorted array of SHOWS; 
#        columns = numpy sorted array of STATES 
show_raw_stats = pandas.DataFrame(0, index=shows, columns=states, dtype='int')
#    (b) show_agg_stats: index = same as above; 
#        columns= a list with the words Max, Min, Totals and Percent in it 
#        (like this… [‘Max’,’Min’,’Totals’, ‘Percent’]  
show_agg_stats = pandas.DataFrame(0,index=shows, columns=['Max','Min','Totals','Percent'])
#(14) Populate show_raw_stats with data from the Original Array injested 
#    from show_results.txt. (a) 
n=0
while(n<statsArray.shape[0]):
    show_raw_stats.ix[statsArray[n][1],str(statsArray[n][0])] += int(statsArray[n][2])
    n+=1
#    HINT:  You will need to create a loop here that basically goes the 
#    length of the original array, and on each iteration, it grabs the 
#    STATE, SHOW, and VIEWERS number (itll be a string so youll have to convert it…).  
#    The final step of each iteration will be placing it in the dataframe in the 
#    correct spot as an accumulation. +=      
#    (Otherwise you just writing over the value there)   
#    (Remember the lecture where we used df.ix…) 
#(15) Populate the Max, Min, Totals, and Percent in show_agg_stats using the 
#    DataFrame native functionality (see lecture)
n=0
maximum = show_raw_stats.max(axis=1)
minimum = show_raw_stats.min(axis=1)
totals = show_raw_stats.sum(axis=1)
percent=0
while(n<show_agg_stats.shape[0]):
    show_agg_stats.ix[n,0] = maximum.ix[n,1]
    show_agg_stats.ix[n,1] = minimum.ix[n,1]
    show_agg_stats.ix[n,2] = totals.ix[n,1]
    percent += totals.ix[n,1]
    n+=1
n=0
#####Just so you know, I'm not sure what you meant by "Percent".#####
while(n<show_agg_stats.shape[0]):
    show_agg_stats.ix[n,3]=100*(show_agg_stats.ix[n,2]/percent)
    n+=1
#(16) Print both dataframe 
print(show_raw_stats)
print('\n',show_agg_stats)
#(17) Print the answer to these questions: 
print("(a) Which Show has the highest percentage?",\
      "\nGame of Thrones")
print("(b) Which Show has the lowest percentage? ",\
      "\nOrange is the New Black")
print("(c) Which show is your favorite? ",\
      "\nEd Edd 'n' eddy.")