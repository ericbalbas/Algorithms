<?php

/**
 * Implementation of sublist search in a linked list.
 * This program checks if a given sublist exists within a main linked list.
 * It uses a two-pointer approach to traverse both lists simultaneously.
 */

// Create list 
class Node
{
    /**
     * Constructor to initialize a Node.
     *
     * @param mixed $value The value of the node.
     * @param Node|null $next The next node in the list.
     */
    public function __construct(public $value, public ?Node $next = null)
    {
    }
}

class LinkedList
{
    /**
     * Constructor to initialize a LinkedList.
     *
     * @param Node|null $head The head node of the list.
     * @param Node|null $tail The tail node of the list.
     */
    public function __construct(public ?Node $head = null, public ?Node $tail = null)
    {
    }

    /**
     * Prepends a new value to the beginning of the list.
     *
     * @param mixed $value The value to be added.
     * @return self Returns the current LinkedList instance.
     */
    public function prepend($value): self
    {
        $this->head = $newNode = new Node($value, $this->head);
        $this->tail ??= $newNode;
        return $this;
    }

    /**
     * Prints the linked list.
     *
     * @return void
     */
    public function print(): void
    {
        $node = $this->head;

        while ($node) {
            echo $node->value;

            if ($node = $node->next) {
                echo " => ";
            }
        }

        echo "<br>";
    }

    /**
     * Checks if a sublist exists within the main list.
     *
     * @param LinkedList $main The main list to search within.
     * @param LinkedList $sub The sublist to search for.
     *
     * @return bool True if the sublist is found, otherwise false.
     */
    public function find($main, $sub): bool
    {
        // If the main list is empty, return false
        if (!$main->head) return false;

        // If the sublist is empty, return true
        if (!$sub->head) return true;

        $mainCurrent = $main->head;

        // Traverse the main list
        while ($mainCurrent) {
            $mainPtr = $mainCurrent;
            $subPtr = $sub->head;

            // Traverse both lists and compare values
            while ($mainPtr && $subPtr && $mainPtr->value === $subPtr->value) {
                $mainPtr = $mainPtr->next;
                $subPtr = $subPtr->next;
            }

            // If the entire sublist is found
            if (!$subPtr) return true;

            $mainCurrent = $mainCurrent->next;
        }

        // Sublist not found
        return false;
    }
}

// Create and populate the main linked list
$ll1 = new LinkedList();
$ll1->prepend(1)
    ->prepend(2)
    ->prepend(3)
    ->prepend(4)
    ->prepend(5)
    ->prepend(6)
    ->prepend(7)
    ->print();

// Create and populate the sublist
$ll2 = new LinkedList();
$ll2->prepend(1)
    ->prepend(2)
    ->print();

// Check if the sublist exists within the main list and print the result
echo $ll1->find($ll1, $ll2) ? "List Found" : "No Found";
