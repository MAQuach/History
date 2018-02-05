#include <stdio.h>
#define NSTATES 3		//number of states in the dfa (i.e. the circles)
#define NCHARS 2		//number of symbols in the dfa's alphabet
#define NACCEPTS 1	//number of different states that are accept states
int L[NSTATES][NCHARS]={{0,1},{0,2},{0,2}};	//two-dimensional array: the first dimension is the dfa state while the second is the input that changes states
int ACCEPTS[NACCEPTS]={2};	//value(s) of the accept state(s)

main()
{
int state,ch,i;

//for loop: receives a string until a new line or '-1' is encountered
//The initial run through the loop results in state = L[0][i], which is either 0 or 1
//If i=0, state=0 for the next run, and we're basically back at the previous comment line.
//If i=1, state=1 for the next run, moving us further through the dfa states (i.e. the first dimension of the array)
//For this particular grammar, any time that i=0 throws us back to the initial state
for (state=0; (ch=getchar())!= -1&&ch!='\n';state=L[state][i])
  {i=ch-'0';}	//converts input from ASCII ('0' == 48) to the actual integer value

for(i=0;i<NACCEPTS;i++)	//Checks if the state that the dfa finished off in is an accepted state
     if(ACCEPTS[i]==state)	//If yes, print yes. Otherwise no.
       {printf("yes\n");return(0);}	//Though simple in this case, this loop is applicable for any #defined constants.

printf("no\n");


return(0);
}
