/*
Michael Quach
mquach2013@fau.edu
Z23255459
	prog        ->  begin stmt_list end

	stmt_list   ->  stmt ; stmt_list
				 |  stmt
				 |	stmt;

	stmt        ->  var = expr

	var         ->  A | B | C

	expr        ->  var + expr
				 |  var - expr
				 |  var

*/

#include    <iostream>
#include    <fstream>
#include    <cctype>

#include    "token.h"
#include    "functions.h"

using namespace std;

ifstream ifs;                   // input file stream used by lexan
SymTab   symtab;                // global symbol table
Token    token;                 // global token
int      lookahead = 0;         // no look ahead token yet
int sign;
int      dbg = 1;               // debut is ON


int main()
{
	ifs = get_ifs();           // open an input file stream w/ the program
	init_kws();                // initialize keywords in the symtab
	match(lookahead);         // get the first input token
	prog();
	return 0;
}


// your methods...

//prog        ->  begin stmt_list end
void prog() {
	//Ensure it starts with 'begin' and not 'end'
	if (token.tokstr() == "begin") {
		emit(KW);
		emit('\n');
		match(KW);
	}
	else {
		error(KW);
	}

	stmt_list();

	//Ensure it ends with 'end'
	if (token.tokstr() == "end") {
		emit('\n');
		emit(KW);
		match(KW);
	}
	else {
		error(KW);
	}
	//It should only be 'DONE' if it hits EOF, so no error checking required.
	match(DONE);
}


//stmt_list   ->  stmt ; stmt_list
//|  stmt
//|	stmt;
void stmt_list() {
	//All possibilities start with a stmt
	stmt();
	//One of the RHS doesn't require a semicolon, so don't throw an error if there isn't one.
	
	if (token.tokstr() == ";") {
		sign = 0;
		//With that token checked, move on.
		emit(';');
		match(';');
		//The first thing a stmt_list should have is an ID since stmt_list -> stmt -> var -> ID, so look for one.
		if (lookahead == ID) {
			stmt_list();
		}
		else if (lookahead == KW) {
			error(KW);
		}
	}
	//But if there isn't a semicolon, it should be the end of the input.
	else if (token.toktype() != KW) {
		error(KW);
	}
}


//stmt        ->  var = expr
void stmt() {
	var();
	//Check for a '='.
	if (token.tokstr() == "=") {
		match('=');
		expr();
		emit('=');
	}
	//A '=' is required, so throw an error if one isn't found.
	else {
		error(token.tokvalue());
	}
}


//var         ->  A | B | C
void var() {
	emit(ID);
	match(ID);
}


//expr        ->  var + expr
//|  var - expr
//|  var
void expr() {
	var();
	if (sign) {
		emit(sign);}
	//Same reasoning as stmt and stmt_list functions.
	if (token.tokstr() == "+") {
		match('+');
		sign = '+';
		expr();
	}
	else if (token.tokstr() == "-") {
		match('-');
		sign = '-';
		expr();
	}
}

// utility methods

void emit( int t )
{
    switch( t )
    {
        case '+': case '-': case '=':
            cout << char( t ) << ' ';
            break;

        case ';':
            cout << ";\n";
            break;

        case '\n':
            cout << "\n";
            break;

        case ID:
        case KW:
        case UID:
            cout << symtab.tokstr( token.tokvalue( ) ) << ' ';
            break;

        default:
            cout << "'token " << t << ", tokvalue "
                 << token.tokvalue( ) << "' ";
            break;
    }
}

void error( int t, int expt, const string &str )
{
    cerr << "\nunexpected token '";
    if( lookahead == DONE )
    {
        cerr << "EOF";
    }
    else
    {
        cerr << token.tokstr( );
    }
    cerr << "' of type " << lookahead;

    switch( expt )
    {
        case 0:         // default value; nothing to do
            break;

        case ID:
            cout << " while looking for an ID";
            break;

        case KW:
            cout << " while looking for KW '" << str << "'";
            break;

        default:
            cout << " while looking for '" << char( expt ) << "'";
            break;
    }

    cerr << "\nsyntax error.\n";

    exit( 1 );
}


void match( int t )
{
	if( lookahead == t )
    {
        token = lexan( );               // get next token
        lookahead = token.toktype( );   // lookahed contains the tok type
    }
    else
    {
        error( t );
    }
}

