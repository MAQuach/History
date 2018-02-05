#Michael Quach
#Problem 1. Prey-Predators-Humans Problem
#Take the prey-predator problem described in Chapter 13 and add humans. 
#Use the file program1314.py, attached to the assignment page. 
# Copyright 2017, 2013, 2011 Pearson Education, Inc., W.F. Punch & R.J.Enbody
"""Predator-Prey Simulation
   four classes are defined: animal, predator, prey, and island
   where island is where the simulation is taking place,
   i.e. where the predator and prey interact (live).
   A list of predators and prey are instantiated, and
   then their breeding, eating, and dying are simulted.
"""
import random
import time
import pylab

class Island (object):
    """Island
       n X n grid where zero value indicates not occupied."""
    def __init__(self, n, prey_count=0, predator_count=0):
        '''Initialize grid to all 0's, then fill with animals
        '''
        # print(n,prey_count,predator_count)
        self.grid_size = n
        self.grid = []
        for i in range(n):
            row = [0]*n    # row is a list of n zeros
            self.grid.append(row)
        self.init_animals(prey_count,predator_count)

    def init_animals(self,prey_count, predator_count):
        ''' Put some initial animals on the island
        '''
        count = 0
        # while loop continues until prey_count unoccupied positions are found
        while count < prey_count:
            x = random.randint(0,self.grid_size-1)
            y = random.randint(0,self.grid_size-1)
            if not self.animal(x,y):
                new_prey=Prey(island=self,x=x,y=y)
                count += 1
                self.register(new_prey)
        count = 0
        # same while loop but for predator_count
        while count < predator_count:
            x = random.randint(0,self.grid_size-1)
            y = random.randint(0,self.grid_size-1)
            if not self.animal(x,y):
                new_predator=Predator(island=self,x=x,y=y)
                count += 1
                self.register(new_predator)

    def clear_all_moved_flags(self):
        ''' Animals have a moved flag to indicated they moved this turn.
        Clear that so we can do the next turn
        '''
        for x in range(self.grid_size):
            for y in range(self.grid_size):
                if self.grid[x][y]:
                    self.grid[x][y].clear_moved_flag()
        
    def size(self):
        '''Return size of the island: one dimension.
        '''
        return self.grid_size

    def register(self,animal):
        '''Register animal with island, i.e. put it at the 
        animal's coordinates
        '''
        x = animal.x
        y = animal.y
        self.grid[x][y] = animal

    def remove(self,animal):
        '''Remove animal from island.'''
        x = animal.x
        y = animal.y
        self.grid[x][y] = 0

    def animal(self,x,y):
        '''Return animal at location (x,y)'''
        if 0 <= x < self.grid_size and 0 <= y < self.grid_size:
            return self.grid[x][y]
        else:
            return -1  # outside island boundary

    def __str__(self):
        '''String representation for printing.
           (0,0) will be in the lower left corner.
        '''
        s = ""
        for j in range(self.grid_size-1,-1,-1):  # print row size-1 first
            for i in range(self.grid_size):      # each row starts at 0
                if not self.grid[i][j]:
                    # print a '.' for an empty space
                    s+= "{:<2s}".format('.' + "  ")
                else:
                    s+= "{:<2s}".format((str(self.grid[i][j])) + "  ")
            s+="\n"
        return s

    def count_prey(self):
        ''' count all the prey on the island'''
        count = 0
        for x in range(self.grid_size):
            for y in range(self.grid_size):
                animal = self.animal(x,y)
                if animal:
                    if isinstance(animal,Prey):
                        count+=1
        return count

    def count_predators(self):
        ''' count all the predators on the island'''
        count = 0
        for x in range(self.grid_size):
            for y in range(self.grid_size):
                animal = self.animal(x,y)
                if animal:
                    if isinstance(animal,Predator):
                        count+=1
        return count

class Animal(object):
    def __init__(self, island, x=0, y=0, s="A"):
        '''Initialize the animal's and their positions
        '''
        self.island = island
        self.name = s
        self.x = x
        self.y = y
        self.moved=False
            
    def position(self):
        '''Return coordinates of current position.
        '''
        return self.x, self.y

    def __str__(self):
        return self.name
    
    def check_grid(self,type_looking_for=int):
        ''' Look in the 8 directions from the animal's location
        and return the first location that presently has an object
        of the specified type. Return 0 if no such location exists
        '''
        # neighbor offsets
        offset = [(-1,1),(0,1),(1,1),(-1,0),(1,0),(-1,-1),(0,-1),(1,-1)] 
        result = 0
        for i in range(len(offset)):
            x = self.x + offset[i][0]  # neighboring coordinates
            y = self.y + offset[i][1]
            if not 0 <= x < self.island.size() or \
               not 0 <= y < self.island.size():
                continue
            if type(self.island.animal(x,y))==type_looking_for:
                result=(x,y)
                break
        return result

    def move(self):
        '''Move to an open, neighboring position '''
        if not self.moved:
            location = self.check_grid(int)
            if location:
                # print('Move, {}, from {},{} to {},{}'.format( \
                #       type(self),self.x,self.y,location[0],location[1]))
                self.island.remove(self)   # remove from current spot
                self.x = location[0]       # new coordinates
                self.y = location[1]
                self.island.register(self) # register new coordinates
                self.moved=True
    def breed(self):
        ''' Breed a new Animal.If there is room in one of the 8 locations
        place the new Prey there. Otherwise you have to wait.
        '''
        if self.breed_clock <= 0:
            location = self.check_grid(int)
            if location:
                self.breed_clock = self.breed_time
                # print('Breeding Prey {},{}'.format(self.x,self.y))
                the_class = self.__class__
                new_animal = the_class(self.island,x=location[0],y=location[1])
                self.island.register(new_animal)

    def clear_moved_flag(self):
        self.moved=False

class Prey(Animal):
    def __init__(self, island, x=0,y=0,s="O"):
        Animal.__init__(self,island,x,y,s)
        self.breed_clock = self.breed_time
        # print('Init Prey {},{}, breed:{}'.format(self.x, self.y,self.breed_clock))
           
    def clock_tick(self):
        '''Prey only updates its local breed clock
        '''
        self.breed_clock -= 1
        # print('Tick Prey {},{}, breed:{}'.format(self.x,self.y,self.breed_clock))

class Predator(Animal):
    def __init__(self, island, x=0,y=0,s="X"):
        Animal.__init__(self,island,x,y,s)
        self.starve_clock = self.starve_time
        self.breed_clock = self.breed_time
        # print('Init Predator {},{}, starve:{}, breed:{}'.format( \
        #       self.x,self.y,self.starve_clock,self.breed_clock))

    def clock_tick(self):
        ''' Predator updates both breeding and starving
        '''
        self.breed_clock -= 1
        self.starve_clock -= 1
        # print('Tick, Predator at {},{} starve:{}, breed:{}'.format( \
        #       self.x,self.y,self.starve_clock,self.breed_clock))
        if self.starve_clock <= 0:
            # print('Death, Predator at {},{}'.format(self.x,self.y))
            self.island.remove(self)

    def eat(self):
        ''' Predator looks for one of the 8 locations with Prey. If found
        moves to that location, updates the starve clock, removes the Prey
        '''
        if not self.moved:
            location = self.check_grid(Prey)
            if location:
                # print('Eating: pred at {},{}, prey at {},{}'.format( \
                #       self.x,self.y,location[0],location[1]))
                self.island.remove(self.island.animal(location[0],location[1]))
                self.island.remove(self)
                self.x=location[0]
                self.y=location[1]
                self.island.register(self)
                self.starve_clock=self.starve_time
                self.moved=True

###########################################
def main(predator_breed_time=6, predator_starve_time=3, initial_predators=10, prey_breed_time=3, initial_prey=50, \
         size=10, ticks=300):
    ''' main simulation. Sets defaults, runs event loop, plots at the end
    '''
    # initialization values
    Predator.breed_time = predator_breed_time
    Predator.starve_time = predator_starve_time
    Prey.breed_time = prey_breed_time

    # for graphing
    predator_list=[]
    prey_list=[]

    # make an island
    isle = Island(size,initial_prey, initial_predators)
    print(isle)

    # event loop. 
    # For all the ticks, for every x,y location.
    # If there is an animal there, try eat, move, breed and clock_tick
    for i in range(ticks):
        # important to clear all the moved flags!
        isle.clear_all_moved_flags()
        for x in range(size):
            for y in range(size):
                animal = isle.animal(x,y)
                if animal:
                    if isinstance(animal,Predator):
                        animal.eat()
                    animal.move()
                    animal.breed()
                    animal.clock_tick()

        # record info for display, plotting
        prey_count = isle.count_prey()
        predator_count = isle.count_predators()
        if prey_count == 0:
            print('Lost the Prey population. Quiting.')
            break
        if predator_count == 0:
            print('Lost the Predator population. Quitting.')
            break
        prey_list.append(prey_count)
        predator_list.append(predator_count)
        # print out every 10th cycle, see what's going on
        if not i%10:
            print(prey_count, predator_count)
        # print the island, hold at the end of each cycle to get a look
#        print('*'*20)
#        print(isle)
#        ans = input("Return to continue")
    pylab.plot(range(0,ticks), predator_list, label="Predators")
    pylab.plot(range(0,ticks), prey_list, label="Prey")
    pylab.legend(loc="best", shadow=True)
    pylab.show()

#A human is a predator that eats prey. It also moves, breeds like an Animal, 
#and kills predators (e.g. to keep prey for humans or for fun). 
#Here are the detailed rules pertaining to humans: 
#    1. A Human object moves like an Animal object on the island grid. 
#    2. A Human object eats Prey just like a Predator object, 
#    with starving time given by a  Human.starve_time class attribute, 
#    initialized in main(). 
#    3. A Human object breeds like an Animal object, with the breeding 
#    period given by a Human.breed_time class attribute, initialized in main(). 
#    4. A Human object hunts Predator objects periodically. 
#    Every Human.hunt_time clock ticks (starting with the Human object’s 
#    creation time), if a Predator is in a neighboring cell (using check_grid()), 
#    the Human will move to its cell and remove the Predator from the island, 
#    in the same way Predators eat Prey objects.
#*** All other rules for Prey and Predators remain in effect.  ***
#We want to study the impact of humans on the island animal populations. 
#Add the following to the Island class: 
#    -- Proper initialization for Human objects. The constructor and 
#    init_animals() should take each an extra parameter count_humans and 
#    init_animals() should position Human objects at random positions. 
#    -- A method count_humans() that returns the number of Human objects on the grid.
#
#The main() method should: 
#    -- Take extra parameters for the Human class attributes described 
#    above and should properly initialize them. 
#    -- Keep track of the Human population for each clock tick in the 
#    same ways it’s done for Predator and Prey objects. 
#    -- NOT stop the simulation if Human objects or Predator get extinct, 
#    but only when Prey dissapear. -- Display at the end with pylab the 
#    evolution in time of the Prey, Predator, and Human populations. 
#    -- Display the island grid to the terminal, at the beginning 
#    and at the end of the simulation. 
#
#More requirements: 
#    1. Add a Human class to the existing class hierarchy so that code 
#    is properly reused. Use the problem description above to decide what 
#    class is Human’s superclass. 
#    2. Use the object-oriented design process. 
#    Integrate class Human smoothly into the existing design and code. 
#    3. No copy-pasted code from other classes is allowed in class Human. 
#    4. Print a Human object on the Island grid with character ‘H’. 
#    5. Apply the proper coding style and techniques taught in this class. 
#    6. Write docstrings for functions and comment your code following 
#    the guidelines from the textbook.
#    
#Preparation Instructions: 
#    1. Write your code in file p1.py. 
#    2. Insert p1.py into h5.doc. 
#    3. Run the program with different combinations of parameters 
#    and find an interesting case. 
#    4. Take a screenshot with the pylab chart showing the populations 
#    vs. time. Insert this screenshot in h5.doc. 
#    5. Take a screenshot with the terminal showing the island grid printout 
#    (first tick and last tick) + any other statistics displayed in main(). 
#    Insert this screenshot in h5.doc.