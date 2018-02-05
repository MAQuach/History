/*Michael Quach
Formal Language and Automata Theory Extra Credit
Spring 2017
Comments exclusive to this implementation (the complement of the universal language).*/

#include <stdio.h>
#define NSTATES 4
#define NCHARS 2
#define NACCEPTS 1
int L[NSTATES][NCHARS] = { { 1,3 },{ 3,2 },{ 2,2 },{ 3,3 } };
int ACCEPTS[NACCEPTS] = { 2 };

main()
{
	int state, ch, i=0;
	char alpha0 = '0', alpha1 = '1';	//Default language, in case none is entered.

	//printf("Please enter the two characters to be used as your alphabet.\nAny excess text will be ignored:");
	scanf("%c%c", &alpha0, &alpha1);	//Scan the first two characters as the language.
	while ((ch = getchar()) != EOF && ch != '\n') {}	//Ignore the rest of the line of text,
						//including \n (otherwise the for loop will automatically terminate).

	for (state = 0; (ch = getchar()) != '\n'; state = L[state][i]) {
		//  {i=ch-'0';}
		if (ch == alpha0) { i = 0; }
		else if (ch == alpha1) { i = 1; }
	}

	//The loop is changed so that all of the original accept states become non-accept states, and vice-versa.
	//In other words, the original accept state of 2 is now the ONLY non-accept state.
	for (i = 0; i<NACCEPTS; i++)
		if (ACCEPTS[i] != state) {
			printf("yes\n");
			return(0); }

	printf("no\n");

	return(0);
}
