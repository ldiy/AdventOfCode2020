#include <stdio.h>
#include <stdlib.h>

struct Node {
    unsigned long data;
    struct Node* next;
    struct Node* prev;
};


void insert(struct Node* prev_node, int data){
    struct Node* new_node = (struct Node*)malloc(sizeof(struct Node));
    new_node->data = data;
    new_node->next = prev_node->next;
    prev_node->next->prev = new_node;
    prev_node->next = new_node;
    new_node->prev = prev_node;

}
void remove_node(struct Node* node){
    node->prev->next = node->next;
    node->next->prev = node->prev;
    node = NULL;
}

int main() {
    int input[9] = {9,5,2,3,1,6,4,8,7};
    static int rounds = 10000000;
    static int number_of_cups = 1000000;

    unsigned long max_value = 1000000;
    struct Node* cups[1000001];

    // Read input into CLL
    struct Node* current_cup = (struct Node*)malloc(sizeof(struct Node));
    current_cup->data = input[0];
    current_cup->next = current_cup;
    current_cup->prev = current_cup;
    cups[input[0]] = current_cup;
    for(int i = 1; i < 1000000; i++) {
        int element;
        if(i<9){
            element = input[i];
        }
        else{
            element = i+1;
        }
        insert(current_cup, element);
        current_cup = current_cup->next;
        cups[element] = current_cup;
    }
    current_cup = current_cup->next;

    for(int i = 0; i < rounds; i++) {
        // Get next cups
        struct Node* c1 = current_cup->next;
        struct Node* c2 = c1->next;
        struct Node* c3 = c2->next;

        // Get destination
        unsigned long destination = current_cup->data - 1;
        if(destination == 0) {
            destination = max_value;
        }
        while(destination == c1->data || destination == c2->data || destination == c3->data) {
            destination--;
            if(destination == 0) {
                destination = max_value;
            }
        }

        // Remove the 3 cups
        current_cup->next = c3->next;
        c3->next->prev = current_cup;

        // Add the 3 cups after destination
        c3->next = cups[destination]->next;
        c1->prev = cups[destination];
        cups[destination]->next->prev = c3;
        cups[destination]->next = c1;

        // Go the the next cup
        current_cup = current_cup->next;
    }

    unsigned long part2 = cups[1]->next->data * cups[1]->next->next->data;
    printf("%lu", part2);
    for(int i = 0; i < 1000000; i++){
        unsigned long test = current_cup->next->data;
        current_cup = current_cup->next;
    }
}