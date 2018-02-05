#include <iostream>

#include <string>

using namespace std;

 

class BST_Node  //node in a BST--?Hold client information

{

  public:

    string lastname, firstname, address, phone_number;

    BST_Node  *lchild, *rchild;   //left and right children pointers

};

 

class Clients_Info_BST //Binary Search Tree

{

   public:

            Clients_Info_BST(){};//stores the data in the hash table

           //Clients_Info_BST(const Clients_Info_BST &);//Copy Constructor

            ~Clients_Info_BST(){};//Destructor           

           //void Insert(const string & s){cout<<"   Inside Client_Info_BST Insert\n";};
		   //Insert adds a new Client's information (into a BST_Node) into the BST

           //  void Remove(const string & s){cout<<"   Inside Client_Info_BST Remove\n";};
		   //Remove deletes a BST_Node that contains the specified client info from the BST if it is there; otherwise
		   //a message should be printed stating so.

           //  void Update(const string & s){cout<<"   Inside Client_Info_BST Update\n";};
		   //Update modifies a client information given the first and last name if it is in the BST; otherwise
		   // prints a message stating so

           //  void Print( ){cout<<"   Inside Client_Info_BST Print\n";};
		   //Print output a BST, INORDER, to the display

           //  BST_Node * Search(const string & s){cout<<"   Inside Client_Info_BST Search\n"; return 0;};

          /* 'Other possible memberf functions (some may be public and some may be private
				bool Empty(); returns true if BST is empty; otherwise false
				void Insert(BST_Node * &, string item); //Auxicilary function used by Insert above to allow recursion
				void Remove(BST_Node * & loc_ptr, string item);//Auxicilary function used by Removbe above to allow recursion
				BST_Node * Search(BST_Node *,string item);Auxicilary function used by Search above to allow recursion
				BST_Node * inorder_succ(BST_Node *);//Return pointer to inorder successor; otherwise 0;
				void Print(BST_Node *);Auxicilary function used by Print above to allow recursion
  

				//You may need to implement other member functions
		*/
    private:

       BST_Node *root; //---state information

};

class Client_Address_Book

{

    public:

            Client_Address_Book(){};//default constructor will read data from input file "client_address_data.txt".

            //Client_Address_Book(const Client_Address_Book &);//Copy Constructor

            //~Client_Address_Book();//Destructor

            // void Insert(const string & s);// insert record
			 //Insert adds a new Client's information to the hash table

            // void Remove(const string & s);//remove record
			//Remove deletes a client from the hash table if it is there; otherwise
		    //a message should be printed stating so.

           //  void Update(const string & s);//update record
		   // see example below

            // void Print_BST(const string & s);//Print a BST (cell in hash table) inorder to the screen

            // void Print_Hash_Table(){"Inside Client_Address_Book Print_Hash_Table\n";};
			//function will print hash table to the screen                          

            // void Print_Hash_Table_to_File(const string & filename);
			//function will print hash table to output file                                                                                                                                                                                

            // bool * Search(const string & s){"Inside Client_Address_Book Search\n"; return 0;};
			//return true if client found; otherwise false

            // unsigned int Hash_Function(const string & s);
			//return the index of the BST in the hash table

 

     // Hint:  Remember that the insert, remove and search function for Clients_Address_Book will use //     

    //Client_Info_BSTs insert, remove and search respectively.

    

  private:

      int capacity;  //SET THIS VALUE EQUAL TO 27  YOUR DEFAULT CONSTRUCTOR

     Clients_Info_BST   *hash_table; // USING 1 THROUGH 26 or whatever you like

};

int main()

{

            Client_Address_Book My_Book;

            //My_Book.Insert("Bullard Lofton 777 Glades Road 207-2780");

            //My_Book.Remove("Bullard Lofton");

 

/*******************************************************************************

Notes for Update Function:

 

     1.  My_Book_Update(1 James Clark Lofton Bullard 777 Glades Run 527-6623);

            If first character is a 1, this means all three fields will be changed.

      2.   My_Book_Update(2 James Clark Lofton Bullard 777 Glades Run);

            If first character is a 2, this means the Name and Address fields will be changed.

      3.   My_Book_Update(3 James Clark 777 Glades Run 555-6666);

            If first character is a 3, this means the Address and Phone Number fields will be changed.

      4.   My_Book_Update(4 James Clark Lofton Bullard 555-6666);

            If first character is a 4, this means the Name and Phone Number fields will be changed.

      5.   My_Book_Update(5 James Clark Lofton Bullard);

            If first character is a 5, this means the Name field will be changed.

      6.   My_Book_Update(6 James Clark 777 Glades Run);

            If first character is a 6, this means the Address field will be changed.

      7.   My_Book_Update(7 James Clark 555-6666);

            If first character is a 7, this means the Phone Number field will be changed.

 

********************************************************************************/

            //My_Book.Update("1 Bullard Lofton  Comb Harry 555 Palmetto Park Road 555-3444");

            //My_Book.Print_BST("B");

            //My_Book.Print_Hash_Table();

 

            //Client_Address_Book Your_Book = My_Book; //Invoke the copy constructor

            //Your_Book.Print_Hash_Table_to_File(/* the output filename goes here*/);

            return 0;

}  

 