/*Michael Quach
Formal Language and Automata Theory Extra Credit
Spring 2017
I'll only include comments specific to this implementation for the sake of readability.*/

#include <stdio.h>
#define NSTATES 4
#define NCHARS 2
#define NACCEPTS 1
int L[NSTATES][NCHARS] = { { 1,3 },{ 3,2 },{ 2,2 },{ 3,3 } };	//States unchanged since the grammar is technically unchanged.
int ACCEPTS[NACCEPTS] = { 2 };

main()
{
	int state, ch, i=0;
	char alpha0 = '0', alpha1 = '1';	//Default language, in case none is entered.

	printf("Please enter the two characters to be used as your alphabet.\nAny excess text will be ignored:");
	scanf("%c%c", &alpha0, &alpha1);	//Scan the first two characters as the language.
	while ((ch = getchar()) != EOF && ch != '\n') {}
	//scanf("%*[^\n]%*c");				//Ignore the rest of the line of text,
	//getchar();						//including \n (otherwise the for loop will automatically terminate).

	for (state = 0; (ch = getchar()) != '\n'; state = L[state][i]) {
		//  {i=ch-'0';}
		if (ch == alpha0) { i = 0; }
		else if (ch == alpha1) { i = 1; }
	}

	//This second loop still only accepts state=2.
	for (i = 0; i<NACCEPTS; i++)
		if (ACCEPTS[i] == state) {
			printf("yes\n");
			return(0); }

	printf("no\n");

	return(0);
}
