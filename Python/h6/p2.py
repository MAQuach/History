#Michael Quach
#Problem 2. Prime Number Generator
#Part a). Iterator Class
class PrimeSeq:
    '''Class that generates the first n prime numbers in sequence.
    n should be greater than 0.'''
    def __init__(self, n):
        self.n = n
        self.x = 2
        self.__primes = []
    
    def __iter__(self):
        return self
    
    def __next__(self):
        while(self.n>=0):
            if(self.n<=0):
                raise StopIteration
            if(len(self.__primes) == 0):
                self.__primes.append(self.x)
                self.n-=1
                self.x+=1
                return self.x-1
            else:
                primed=True
                for ii in self.__primes:
                    if((self.x/ii).is_integer()):
                        self.x+=1
                        primed=False
                        continue
                if(primed):
                    self.__primes.append(self.x)
                    self.n-=1
                    self.x+=1
                    return self.x-1

#Part b). Generator
def prime_gen(n):
    '''Generator for a sequence of the first n prime numbers.
    n should be greater than 0, else StopIteration is raised. No side effects.'''
    x=2
    while n>=0:
        if(n<=0):
            raise StopIteration
        if(x==2):
            n-=1
            yield x
            x+=1
        else:
            primed=True
            for ii in range(2,x):
                if((x/ii).is_integer()):
                    x+=1
                    primed=False
            if(primed):
                n-=1
                yield x
                x+=1

def main():
    '''Demonstrates PrimeSeq class and prime_seq function.'''
    print("Demonstrating PrimeSeq:")
    seq1 = PrimeSeq(100)
    primes1 = [x for x in seq1]
    print(primes1)

    print("Demonstrating prime_seq(100)")   
    seq2 = prime_gen(100)
    primes2 = [x for x in seq2]
    print(primes2)