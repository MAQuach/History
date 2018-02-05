from collections import deque
pid, progs, ttime=1,8,0
#pcbs = open('pcbs.txt','w')

class Process:
    def __repr__(self):
        '''printing a Process object returns its name and current burst quantity'''
        if(self.done):
            return self.name + " has terminated."
        else:
            return self.name+ '['+ str((self.bursts[self.cursor]))+ ']'
        
    def __init__(self, name, bursts):
        '''initializes a process'''
        global pid
        self.name, self.cursor, self.turn, self.wait, \
        self.pid, self.bursts, self.done, self.react = name,0,0,0,pid,[],False,-1
        #creates deep copy just in case
        for ii in range(len(bursts)):
            self.bursts.append(bursts[ii])
        pid+=1
        self.ttr = 0
        
    def isio(self):
        '''returns True if this process should be in the IO queue'''
        return bool(self.cursor%2)
                
    def current(self):
        '''returns current burst quantity, or -1 if no more bursts'''
        if(self.done):
            return -1
        else:
            return self.bursts[self.cursor]
            
    def time(self, pid):
        '''simulates the passing of time for this process'''
        #if the process is done, do nothing
        if(self.done):
            return self.name + " has terminated."
        #if it's in IO, decrement burst. don't increment waiting time
        if(self.isio()):
            self.turn+=1
            self.w8()
        #not in io and doesn't have CPU -> waiting
        elif(self.pid!=pid):
            self.wait+=1
            self.turn+=1
        #not in io and does have CPU -> performing CPU burst
        else:
            self.turn+=1
            self.go()
    def w8(self):
        if(self.isio()):
            self.proceed()
    def go(self):
        if(self.isio()):
            print("ERROR: ATTEMPTING CPU BURST DURING IO")
        else:
            self.proceed()
    def proceed(self):
        '''w8(), go(), and this are helper methods for time()'''
        #currently in IO or CPU, so decrement the burst
        self.bursts[self.cursor]-=1
        #set response time if this is the first CPU burst
        #processes always start with a CPU burst
        #so an IO burst should not set the response time
        if(self.react == -1):
            global ttime
            self.react = ttime-1
        #if the burst is done, move to the next burst and print the PCB
        if(self.current() == 0):
            self.cursor +=1
            self.print_pcb()
        #if there aren't anymore bursts, remove the process and print PCB
        if(self.cursor == len(self.bursts)):
            global progs
            progs-=1
            self.done=True
            self.print_pcb()
            
    def print_pcb(self):
        '''prints PCB of a process when it changes queues'''
        global ttime, pcbs
        print("\n\nPCB for "+self.name)
        print("\nTotal time elapsed: " + str(ttime) + "\tResponse time: " + str(self.react))
        print("\nWaiting time: " + str(self.wait) + "\t\tTurnaround: " + str(self.turn))
        if(self.done):
            print("\nNo bursts remaining.\n")
        elif(self.isio()):
            print("\nMoving to IO.")
        else:
            print("\nMoving to Ready.")
            
def passTime(lid, threads):
    '''cycles through processes to simulate the passing of time'''
    global ttime
    ttime+=1
    for ii in range(len(threads)):
        threads[ii].time(lid)
        
def fcfs(threads):
    '''First-come first-served scheduling algorithm'''
    #initializing queues and variables
    global pcbs, progs
    print("FCFS:\n")
    queue,io,progs,notU = deque(),deque(),len(threads),0
    for ii in range(len(threads)):
        queue.append(threads[ii])
        
    #fcfs algorithm
    #while there's something to run
    while(len(queue)>0 or progs>0):
        #if nothing's in the ready queue, wait
        if(len(queue)==0):
            notU +=1
            passTime(0, threads)
        #if there is and it belongs in IO, move it to IO
        if(len(queue)>0 and queue[0].isio() == True):
            io.append(queue[0])
            queue.popleft()
            print("\nReady q: "+str(queue)+"\nIO q: "+str(io))
        #pass time, if there's anything to pass it for
        if(len(queue)>0):
            passTime(queue[0].pid, threads)
        
        #if anything in IO finishes its burst, pull it back into the ready queue
        ii=0
        while(ii<len(io)):
            if(io[ii].isio()==False):
                queue.append(io[ii])
                io.remove(io[ii])
            else:
                ii+=1
                
    finish(threads, notU)
    
def sjf(threads):
    '''SJF scheduling algorithm with no preemption'''
    print("\n\n\nSJF:\n")
    #initialization
    global pcbs, progs, ttime
    ttime,notU,progs=0,0,len(threads)
    queue,io = deque(),deque()
    for ii in range(len(threads)):
        queue.append(threads[ii])
    #while there's something to run
    while(len(queue)>0 or progs>0):
        small = 0
        #if they're all in IO, wait
        if(len(queue)==0 and progs>0):
            notU+=1
            passTime(0,threads)
        #if not, look for the smallest burst available
        else:
            for ii in range(len(queue)):
                if(queue[ii].current()>0 and queue[small].current() > queue[ii].current()):
                    small = ii
            #and then run that burst
            while(not queue[small].isio()):
                passTime(queue[small].pid, threads)
        #then send it to IO
        if(len(queue)>0 and queue[small].isio()):
            io.append(queue[small])
            queue.remove(queue[small])
        #retrieve any processes that finished IO
        ii=0
        while(ii<len(io)):
            if(io[ii].isio()==False):
                queue.append(io[ii])
                io.remove(io[ii])
            else:
                ii+=1
        print("\nReady q: "+str(queue)+"\nIO q: "+str(io))
                   
    finish(threads, notU)

def mlfq(threads):
    '''MLFQ scheduler with priorities of RR (Tq=6), RR (Tq=11), and FCFS'''
    print("\n\n\nMLFQ:")
    #initialization
    global ttime, pcbs, progs
    ttime,notU,tq1,tq2,progs=0,0,6,11,len(threads)
    queue1, queue2, queue3, io1, io2, io3 = deque(),deque(),deque(),deque(),deque(),deque()
    
    for ii in range(len(threads)):
        queue1.append(threads[ii])
    #while there's something to run
    while(len(queue1)>0 or len(queue2)>0 or len(queue3)>0 or progs>0):
        #if EVERYTHING in EVERY queue is in IO, wait
        if(len(queue1)==0 and len(queue2)==0 and len(queue3)==0):
            notU+=1
            passTime(0,threads)
            print("\nQ1: "+str(queue1)+"\nQ2: "+str(queue2)+"\nQ3: "+str(queue3))
        else:
            #otherwise, do something in the first queue that's not empty
            #Priority 1: RR with Tq == 6
            if(len(queue1)>0 and progs>0):
                #send to IO if it finished and reset Tq
                if(len(queue1)>0 and queue1[0].isio()):
                    io1.append(queue1[0])
                    queue1.popleft()
                    tq1=6
                #if Tq expired, downgrade the process
                if(tq1<=0):
                    print("\n"+queue1[0].name+" is being downgraded to priority 2.\n")
                    queue2.append(queue1[0])
                    queue1.popleft()
                    tq1=6
                print("\nIn Priority 1.")
                print("\nQ1: "+str(queue1)+"\tQ1 IO: "+str(io1)+\
                           "\nQ2: "+str(queue2)+"\tQ2 IO: "+str(io2)+\
                           "\nQ3: "+str(queue3)+"\tQ3 IO: "+str(io3))
                if(len(queue1)>0):
                    passTime(queue1[0].pid, threads)
                tq1-=1
            #Priority 2: RR with Tq == 11
            elif(len(queue2)>0 and progs>0):
            #same logic as Priority 1, just with different variables
                if(len(queue2)>0 and queue2[0].isio()):
                    io2.append(queue2[0])
                    queue2.popleft()
                    tq2=11
                if(tq2<=0):
                    print("\n"+queue2[0].name+" is being downgraded to priority 3.\n")
                    queue3.append(queue2[0])
                    queue2.popleft()
                    tq2=11
                print("\nIn Priority 2.")
                print("\nQ1: "+str(queue1)+"\tQ1 IO: "+str(io1)+\
                           "\nQ2: "+str(queue2)+"\tQ2 IO: "+str(io2)+\
                           "\nQ3: "+str(queue3)+"\tQ3 IO: "+str(io3))
                if(len(queue2)>0):
                    passTime(queue2[0].pid, threads)
                tq2-=1
            #Priority 3: FCFS
            #if there's anything here, run it
            elif(len(queue1)<=0 and len(queue2)<=0):
                if(len(queue3)>0 or progs>0):
                    if(len(queue3)>0 and queue3[0].isio()):
                        io3.append(queue3[0])
                        queue3.popleft()
                    print("\nIn Priority 3.")
                    print("\nQ1: "+str(queue1)+"\tQ1 IO: "+str(io1)+\
                           "\nQ2: "+str(queue2)+"\tQ2 IO: "+str(io2)+\
                           "\nQ3: "+str(queue3)+"\tQ3 IO: "+str(io3))
                    if(len(queue3)>0):
                        passTime(queue3[0].pid, threads)
                        
        #retrieve processes that completed IO and put them in the correct ready queues
        ii=0
        while(ii<len(io1)):
            if(io1[ii].isio()==False):
                queue1.append(io1[ii])
                io1.remove(io1[ii])
            else:
                ii+=1
        ii=0
        while(ii<len(io2)):
            if(io2[ii].isio()==False):
                queue2.append(io2[ii])
                io2.remove(io2[ii])
            else:
                ii+=1
        ii=0
        while(ii<len(io3)):
            if(io3[ii].isio()==False):
                queue3.append(io3[ii])
                io3.remove(io3[ii])
            else:
                ii+=1
                
    finish(threads, notU)
    
def init():
    '''initialize processes with their respective bursts and return a list of them'''
    P1 = Process('P1', [4,  24, 5,  73, 3,  31, 5,  27, 4,  33, 6,  43, 4,  64, 5,  19, 2])
    P2 = Process('P2', [18, 31, 19, 35, 11, 42, 18, 43, 19, 47, 18, 43, 17, 51, 19, 32, 10])
    P3 = Process('P3', [6,  18, 4,  21, 7,  19, 4,  16, 5,  29, 7,  21, 8,  22, 6,  24, 5])
    P4 = Process('P4', [17, 42, 19, 55, 20, 54, 17, 52, 15, 67, 12, 72, 15, 66, 14])
    P5 = Process('P5', [5,  81, 4,  82, 5,  71, 3,  61, 5,  62, 4,  51, 3,  77, 4,  61, 3,  42, 5])
    P6 = Process('P6', [10, 35, 12, 41, 14, 33, 11, 32, 15, 41, 13, 29, 11])
    P7 = Process('P7', [21, 51, 23, 53, 24, 61, 22, 31, 21, 43, 20])
    P8 = Process('P8', [11, 52, 14, 42, 15, 31, 17, 21, 16, 43, 12, 31, 13, 32, 15])

    return [P1,P2,P3,P4,P5,P6,P7,P8]
    
def finish(threads, notU):
    '''print the stats for the simulation'''
    global ttime
    totalTW, totalTTR, totalTR = 0,0,0
    print("----------Simulation complete----------")
    print("Time elapsed:"+ str(ttime))
    print("Times:\t\tWaiting\t\tTurnaround\t\tResponse")
    for ii in range(len(threads)):
        totalTW += threads[ii].wait
        totalTTR += threads[ii].turn
        totalTR += threads[ii].react
        print(threads[ii].name+"\b:\t\t"+str(threads[ii].wait)+"\t\t"+str(threads[ii].turn)+"\t\t"+str(threads[ii].react))
    print("Averages:\t\t"+str(totalTW/8)+"\t\t"+str(totalTTR/8)+"\t\t"+str(totalTR/8))
    print("CPU Utilization: %"+ str(100*((ttime-notU)/ttime)))
    
#try:
fcfs(init())
sjf(init())
mlfq(init())
#finally:
#    pcbs.close()