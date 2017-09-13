#include <mpi.h>

int main(int argc, char *argv[]){
	int rank, n, buf = 0;
	MPI_Init(&argc, &argv);

	MPI_Comm_rank(MPI_COMM_WORLD, &rank);
	MPI_Comm_size(MPI_COMM_WORLD, &n);

	MPI_Request *request = new MPI_Request[n*2-2];

	int j = -1;
	for(int i = 0; i < n; i++){
		if(rank != i){
			MPI_Isend(&rank, 1, MPI_INT, i, 1, MPI_COMM_WORLD, &request[++j]);
		}
	}

	for(int i = 0; i < n; i++){
		if(rank != i){
			MPI_Irecv(&buf, 1, MPI_INT, i, 1, MPI_COMM_WORLD, &request[++j]);
			printf("[%d] receive message \'%d\' from %d\n", rank, buf, i);
		}
	}

	MPI_Waitall(n*2-2, request, MPI_STATUSES_IGNORE);

	delete [] request;

	MPI_Finalize();

	return 0;
}