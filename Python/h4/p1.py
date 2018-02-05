#Michael Quach
#Problem 1. Top Movies and Actors
#This problem is about analyzing data from IMDB lists with top rated and top 
#grossing movies. There are these files linked from the Homework 4 Canvas page: 
#-- imdb-top-rated.csv, listing the ranking of the top rated 250 movies. 
#   It has this format: Rank,Title,Year,IMDB Rating 
#-- imdb-top-grossing.csv, listing the ranking of the highest grossing 250 movies. 
#   It has this format: Rank,Title,Year,USA Box Office 
#-- imdb-top-casts.csv, listing the director and cast for the movies in the above files. 
#   It has this format: Title, Director, Actor 1, Actor 2, Actor 3, Actor 4, Actor 5. 
#   The actors are listed in billing order. This file does not have a heading. 
#These files are from Duke U. and seem to date from 2014.
#
rated = open("imdb-top-rated.csv","r",encoding='utf8')      #Rank,Title,Year,IMDB Rating
gross = open("imdb-top-grossing.csv","r",encoding='utf8')   #Rank,Title,Year,USA Box Office
casts = open("imdb-top-casts.csv","r",encoding='utf8')      #Title,Director,Actor1,Actor2...Actor5

ratedd = {}
grossd = {}
castsd = {}

for line in rated:
    thisline = line.strip().split(',')
    ratedd = {(thisline[0],thisline[1]): (thisline[2],thisline[3])}
    print(ratedd[(thisline[0],thisline[1])])
    
for line in gross:
    thisline = line.strip().split(',')
    grossd = {(thisline[0],thisline[1]): (thisline[2],thisline[3])}
    print(grossd[(thisline[0],thisline[1])])
    
for line in casts:
    thisline = line.strip().split(',')
    castsd = {(thisline[0],thisline[1]): (thisline[2],thisline[3])}
    print(castsd[(thisline[0],thisline[1])])
    
#######Wait what? How the hell do I sort a bunch of tuples by one of its values? Why am I not using a list or matrix for this????
#Write a program in file p1.py that does the following: 
#a) Displays a ranking (descending) of the movie directors with the most movies in the top rated list. 
#    Print only the top 5 directors, with a proper title above.
#b) Displays a ranking (descending) of the directors with the most movies in the top grossing list. 
#    Print only the top 5 directors, with a proper title above.
#c) Displays a ranking (descending) of the actors with the most movie credits from the top rated list. 
#    Print only the top 5 actors, with a proper title above.
#d) Displays a ranking (descending) with the actors who brought in the most box office money, 
#    based on the top grossing movie list. For a movie with gross ticket sales amount s, 
#    the 5 actors on the cast list will split amount s in the following way: 
#Actor           # 1 (first billed)  2       3       4       5 
#$$ per actor    16*s/31             8*s/31  4*s/31  2*s/31  s/31
#Print only the top 5 actor pairs, with a proper title above.
#
#EXTRA CREDIT 5 points: 
#e) Displays in order the top 10 “grossing actor pairs” that played together in the same movie. 
#The total amount (used for sorting) for a pair of actors is the sum of the gross 
#revenue allocated to each actor with the scheme in the table above, but computed 
#only for movies where the two actors played together. We can expect Harrison Ford 
#and Mark Hamill to be near the top, since they were together in the original Star Wars movies. 
#
#Take a screenshot of the program’s output (a-d + e) and insert it in the h4.doc 
#file right after the code from file p1.py.
#Design and Implementation Requirements 
#To get credit for this problem, follow these requirements: 
#    a) Apply the top-down design methodology. Seek commonality among the tasks listed above. 
#Break the problems into subproblems divide&conquer-style, then write functions dealing 
#with the subproblems. 
#    b) Compute and use 3 dictionaries with the key in the form of a tuple 
#(movie_name, movie_year) for storing movie cast information, ratings info, and 
#gross info, respectively. We need to include the year as part of the key since 
#it’s possible in principle to get two different movies with the same title, but 
#it is less likely to be from the same year. Use a dictionary for storing actor 
#information with the key being the actor name and value being the list of 
#(movie_name, movie_year) tuples for movies in which they played, and any other 
#data needed, such as gross allocated (per the table above). Store multiple values 
#for one entry in a tuple or list. 
#    c) Write docstrings for functions and comment your code following the guidelines 
#from the textbook. Follow the Python coding style rules.