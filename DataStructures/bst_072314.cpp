/*
  This is a simple program to give the student experience writing code
  for binary trees.  This is a CLASS implementation of the BST ADT. 
  The student should study, comment, correct errors, compile, 
  implement/un-implemented/undeveloped functions, and modify code to make
  it more efficient when ever necessary. The student should be able to
  discuss the advantages and disadvantages of using such an
  implementation.
*/


#include <iostream>
#include <string>

using namespace std;

class treenode
{
public:
   string info;
   treenode *lchild, *rchild;
};

class BST
{
public:
	BST(){root=0;}
	~BST();
	bool empty();
	void insert(string item);
	void insert_aux(treenode * &, string item);
	void insert_Iterate(string item);
	void del(string item);
	void del_aux(treenode * & loc_ptr, string item);
	treenode * search_tree_aux(treenode *,string item);
	treenode * search_tree(string item);
	treenode * search_tree_Iterate(string item);
	treenode * inorder_succ(treenode *);
	treenode * parent();
	void print_tree();
	void print_tree_aux(treenode *);
	int count_node();
	int count_node(treenode *);
	int count_node(treenode *, string r1, string r2);
	int count_node(string r1, string r2);

private:
	treenode *root;

};

bool BST::empty()
{
   return (root==0);
}

void BST::insert(string item)
{
	
	insert_aux(root,item);
}
     
void BST::insert_aux(treenode * & loc_ptr,string item)
{
    if (loc_ptr==0)
    {
       loc_ptr = new treenode;
       loc_ptr->lchild=loc_ptr->rchild=0;
       loc_ptr->info=item;
    }
    else if (loc_ptr->info>item)
       insert_aux(loc_ptr->lchild,item);
    else if (loc_ptr->info<item)
       insert_aux(loc_ptr->rchild,item);
    else
       cout<<"the item is already in the tree\n";
}

void BST::insert_Iterate(string item)
{
	treenode *parent, *loc_ptr = root;

	treenode *loc_ptr2 = new treenode;
    loc_ptr2->lchild=loc_ptr2->rchild=0;
    loc_ptr2->info=item;

	if (root == 0)
    {
       root = loc_ptr2;
	   return;
    }

	while(loc_ptr != 0)
	{
		parent = loc_ptr;

		if(loc_ptr->info==item)
		{
			cout<<"Duplicate in tree; do nothing!\n";
			delete loc_ptr2;
			return;
		}
		else if (loc_ptr->info>item)
		{
			loc_ptr = loc_ptr->lchild;
		}
        else if (loc_ptr->info<item)
		{
			loc_ptr = loc_ptr->rchild;
		}		
	}

	if (parent->info<item)
	{
	   parent->rchild = loc_ptr2;
	}
	else
	{
		parent->lchild = loc_ptr2;
	}	
}


treenode * BST::search_tree(string item)
{
	return search_tree_aux(root, item);
}

treenode * BST::search_tree_aux(treenode * loc_ptr, string item)
{
    if (loc_ptr!=0)
    {
       if(loc_ptr->info==item)
          return loc_ptr;
       else if (loc_ptr->info>item)
          return search_tree_aux(loc_ptr->lchild,item);
       else
          return search_tree_aux(loc_ptr->rchild,item);
    }
    else
         return loc_ptr;
}

treenode * BST::search_tree_Iterate(string item)
{
		treenode * loc_ptr = root;

		 while(loc_ptr != 0)
		 {
			if(loc_ptr->info==item)
				return loc_ptr;
			 else if (loc_ptr->info>item)
                loc_ptr = loc_ptr->lchild;
             else
                loc_ptr = loc_ptr->rchild;
			
		 }

		 return loc_ptr;
}
		

void BST::del(string item)
{
	del_aux(root,item);
}

void BST::del_aux(treenode * & loc_ptr, string item)
{

   if (loc_ptr==0)
       cout<<"item not in tree\n";

   else if (loc_ptr->info > item)
       del_aux(loc_ptr->lchild, item);

   else if (loc_ptr->info < item)
       del_aux(loc_ptr->rchild, item);
   
   else
   {
       treenode * ptr;

       if (loc_ptr->lchild == 0)
       {
          ptr=loc_ptr->rchild;
          delete loc_ptr;
          loc_ptr=ptr;
       }
       else if (loc_ptr->rchild == 0)
       {
          ptr=loc_ptr->lchild;
          delete loc_ptr;
          loc_ptr=ptr;
       }
       else
       {
          ptr=inorder_succ(loc_ptr);
          loc_ptr->info = ptr->info;
          del_aux(loc_ptr->rchild, ptr->info);
       }
    }

}

treenode * BST::inorder_succ(treenode * loc_ptr)
{

  treenode *ptr=loc_ptr->rchild;

  while(ptr->lchild!=0)
  {
     ptr=ptr->lchild;
  }
  return ptr;
}
 
void BST::print_tree()
{
	print_tree_aux(root);
}

void BST::print_tree_aux(treenode * loc_ptr)
{
  if (loc_ptr!=0)
  {
   print_tree_aux(loc_ptr->lchild);
   cout<<loc_ptr->info<<endl;
   print_tree_aux(loc_ptr->rchild);
  }
}


BST::~BST()
{
   while (root!=0)
   {
	   del(root->info);
   }
}

int BST::count_node()
{
	return count_node(root);
}

int BST::count_node(treenode * loc_ptr)
{
	if (loc_ptr == 0)
	{
		return 0;
	}
	else
	{
		return 1 + count_node(loc_ptr->lchild) + count_node(loc_ptr->rchild);
	}
}

int BST::count_node(string r1, string r2)
{
	return count_node(root, r1, r2);
}

int BST::count_node(treenode * r, string r1, string r2)
{
	if (r == 0)
		return 0;
	else if (r->info >= r1 && r->info <= r2)
		return 1 + count_node(r->lchild,r1,r2) + count_node(r->rchild,r1,r2);
	else if (r->info > r2)
		return count_node(r->lchild,r1,r2);
	else if (r->info < r1)
		return count_node(r->rchild,r1,r2);
	else
		return 0;
}


int main()
{
    BST B;
	//treenode *root1=0, *root2=0;
    string s;
    char ch;
    string key3; 
    string key4;
	string response;
	string r1, r2;
    cout<<"enter command, c=count, i=insert item,s=search tree,d=delete item,p=print tree, r = range, e=exit: ";
    cin>>ch;
    cout<<endl;

    while (ch!='e')
    {
       switch (ch)
       {
	   case 'i'  :cout<<"enter string: ";
             cin>>s;
             B.insert_Iterate(s);
             break;
 
       case 's'  :cout<<"enter word to search for: ";
             cin>>s;
             if (!B.search_tree_Iterate(s))
                cout<<s<<"not in tree\n";
             else
                cout<<s<<" was found in the tree\n";
             break;
       case 'd'  :cout<<"enter word to delete: ";
                  cin>>s;
                  B.del(s);
                  break;
       case 'p'  :cout<<"...printing tree...\n";
             B.print_tree();
			 break;
		case 'c'  :cout<<"...count nodes...\n";
			cout<<"there are "<<B.count_node()<<" nodes\n";
			break;
		case 'r'  :cout<<"...count nodes in range...\n";
			cout<<"enter range (string) r1 then r2:";
			
			cin>>r1>>r2;
			cout<<"there are "<<B.count_node(r1,r2)<<" nodes\n";
			break;
	   
				default:break;
      }
      cout<<"enter command, i=insert item,s=search tree,d=delete item,p=print tree,r = range, e=exit: ";
      cin>>ch;
      cout<<endl;
    }
 
    cout<<endl<<"no more binary tree.....\n";
    return 0;
} 
     


