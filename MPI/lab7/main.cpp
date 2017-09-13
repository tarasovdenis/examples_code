#include <mpi.h>

int main(int argc, char * argv[]){

	MPI_Init(&argc, &argv);
	int rank, n, buf, next, prev;
	MPI_Comm_rank(MPI_COMM_WORLD, &rank);
	MPI_Comm_size(MPI_COMM_WORLD, &n);
	MPI_Request request[2];

	if(rank == n-1) 
		next = 0;
	else
		next = rank + 1;

	if(rank == 0)
		prev = n-1;
	else
		prev = rank - 1;

	buf = rank;

	MPI_Isend(&buf, 1, MPI_INT, next, 1, MPI_COMM_WORLD, &request[0]);
	MPI_Irecv(&buf, 1, MPI_INT, prev, 1, MPI_COMM_WORLD, &request[1]);
	MPI_Waitall(2, request, MPI_STATUSES_IGNORE);
	printf("[%d] receive message: %d\n", rank, buf);

	MPI_Finalize();

	return 0;
}