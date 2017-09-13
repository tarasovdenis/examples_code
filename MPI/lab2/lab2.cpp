#include <stdio.h>
#include "mpi.h"

int main(int argc, char* argv[]){
	MPI_Init(&argc, &argv);
	int n;
	MPI_Comm_rank(MPI_COMM_WORLD, &n);
	if(n == 0){
		int size;
		MPI_Comm_size(MPI_COMM_WORLD, &size);
		printf("%d processes.\n", size);
	}
	else
		if(n % 2 == 0){
			printf("I am %d process: SECOND!\n", n);
		}
		else
			printf("I am %d process: FIRST\n", n);
	MPI_Finalize();
	return 0;
}