<?php

/**
 * Doubly Linked List Implementation in PHP
 *
 * A doubly linked list is a type of linked list where each node contains a reference
 * to the next node and the previous node in the sequence. This allows traversal of
 * the list in both forward and backward directions.
 *
 * Diagram:
 *        |----------|-----------|----------|  
 *    +------+    +------+    +------+    +------+
 *    | Prev |<-->|  A   |<-->|  B   |<-->| Next |
 *    +------+    +------+    +------+    +------+
 *
 * - Each node contains a 'value', 'prev' pointer to the previous node, and 'next'
 *   pointer to the next node.
 * - The 'head' pointer points to the first node in the list, and the 'tail' pointer
 *   points to the last node in the list.
 * - Operations include prepend, append, insertAfter, and remove.
 */

/**
 * Class DNode  
 * 
 * Represents a node in a doubly linked list.
 * 
 * Creator : Eric John Balbas
 * 28-05-2024
 */
class DNode
{
    /**
     * DNode constructor.
     * 
     * @param mixed $value The value to be stored in the node.
     * @param DNode|null $prev The previous node in the list, or null if there is no previous node.
     * @param DNode|null $next The next node in the list, or null if there is no next node.
     */
    public function __construct(public $value, public ?DNode $prev = null, public ?DNode $next = null)
    {
    }
}


/**
 * Class DoublyLinkedList
 * 
 * Represents a doubly linked list.
 */
class DoublyLinkedList
{
    /**
     * DoublyLinkedList constructor.
     * 
     * @param DNode|null $head The head node of the list, or null if the list is empty.
     * @param DNode|null $tail The tail node of the list, or null if the list is empty.
     */
    public function __construct (public ?DNode $head = null, public ?DNode $tail=null){ }

    /**
     * Prints the values of the nodes in the list.
     * 
     * Outputs the values of the nodes in the list in order, separated by ' <=> '.
     */
    public function print()
    {
        $node = $this->head;
        $output = ' • ';

        while ($node) {
            $output .= $node->value;

            if ($node->next) {
                $output .= " • ←→ • ";
            }

            $node = $node->next;
        }

        echo $output . " • <br>";
    }

    public function customPrint()
    {
        $node = $this->head;
        while ($node) {
            echo "<hr>Node value: {$node->value}<br>";
            echo "Prev: " . ($node->prev ? $node->prev->value : 'null') . "<br>";
            echo "Next: " . ($node->next ? $node->next->value : 'null') . "<br>";
            echo "<hr>";
            $node = $node->next;
        }
    }

    /**
     * Prepends a new node with the given value to the beginning of the doubly linked list.
     * 
     * @param mixed $value The value to be stored in the new node.
     * @return self The current instance of the DoublyLinkedList for method chaining.
     */
    public function prepend($value): self
    {

        //Create new node tiwh the given value, prev will always null this is prepend, and the next will the current head
        $newNode = new DNode($value, null, $this->head);

        if (!$this->head) {
            $this->tail = $newNode;
        } else {
            $this->head->prev = $newNode;
        }

        $this->head = $newNode;
        return $this;
    }

    /**
     * Append a new node with the given value to the end of the list.
     *
     * @param mixed $value The value to be stored in the new node.
     * @return self The current instance of the DoublyLinkedList for method chaining.
     */
    public function append($value) : self
    {
        // Create a new node with the given value and the current tail as its previous node.
        $newNode = new DNode($value, $this->tail);

        // If the tail is null, it means the list is empty.
        // In this case, set the head to the new node.
        if (!$this->tail) {
            $this->head = $newNode;
        } else {
            // If the tail is not null, set the next of the current tail to the new node.
            $this->tail->next = $newNode;
        }

        // Set the new node as the tail of the list.
        $this->tail = $newNode;

        // Return the current instance for method chaining.
        return $this;
    }


    /**
     * Insert a new node with the given value after the specified node.
     *
     * @param mixed $value The value to be stored in the new node.
     * @param DNode $prev The node after which the new node will be inserted.
     * @return DNode The newly created node.
     */
    public function insertAt($value, DNode $prev) : DNode
    {

        $newNode = new DNode($value, $prev, $prev->next); 
        $prev->next = $newNode;

        if ($newNode->next) {
            $newNode->next->prev = $newNode;
        } else {
            $this->tail = $newNode;
        }

        return $newNode;
    }


     /**
     * Removes a specified node from the doubly linked list.
     * 
     * @param DNode $remove The node to be removed.
     * @return DNode The removed node.
     */
    public function remove(DNode $remove) : DNode
    {
        if($remove->prev) $remove->prev->next = $remove->next;
        else $this->head = $remove->next;

        if($remove->next) $remove->next->prev = $remove->prev;
        else $this->tail = $remove->prev;

        $remove->prev = null;
        $remove->next = null;

        return $remove;
    }

    /**
     * Get the node at the specified index.
     *
     * @param int $index The index of the node to retrieve (0-based).
      * @return DNode|null The node at the specified index, or null if the index is out of bounds.
     */
    public function getNodeByIndex(int $index) : ?DNode
    {
        if($index < 0) return null;

        $currentNode = $this->head;
        $currentIndex = 0;

        //Traverse the list until the count of index
        while ($currentNode && $currentIndex < $index)
        {
            $currentNode = $currentNode->next;
            $currentIndex++;
        }

        return $currentNode;
    }

    /**
     * Get the node with the specified value.
     *
     * @param mixed $value The value to search for.
     * @return DNode|null The node with the specified value, or null if not found.
     */
    public function getNodeByValue($value) : ?DNode
    {
        if(!$value) return null; // return null if value is no data

        $currentNode = $this->head; //getting the head
        while($currentNode)
        {
            if($currentNode->value === $value) return $currentNode; //return the current node if match
            $currentNode = $currentNode->next;
        }

        return null;
    }

}
// Example usage
$dll = new DoublyLinkedList();

// Chaining method
$dll->prepend('A')
    ->prepend('B')
    ->prepend('C')
    ->append('newtail')
    ->print(); // C <=> B <=> A


$nodeB = $dll->head->next; // traverse to node B
$newNode = $dll->insertAt("B.1", $nodeB);
$dll->remove($nodeB);

echo "<pre>" . print_r($dll->getNodeByValue("B"), true) . "</pre>";

$dll->customPrint(); //to check where the pointers

echo "<pre>" . print_r($dll, true) . "</pre>";
?>