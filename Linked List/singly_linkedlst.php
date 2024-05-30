<?php

/**
 * Class SNode
 * 
 * Represents a SNode in a singly linked list.
 * Creator : Eric John Balbas
 * Date : 28-05-2024
 */
class SNode
{
    /**
     * SNode constructor.
     * 
     * @param mixed $value The value to be stored in the SNode.
     * @param SNode|null $next The next SNode in the list, or null if there is no next SNode.
     */ 
    public function __construct(public $value, public ?SNode $next = null) { }
}


/**
 * Class SinglyLinkedList
 * 
 * Represents a singly linked list.
 */
class SinglyLinkedList
{
    /**
     * SinglyLinkedList constructor.
     * 
     * @param SNode|null $head The head SNode of the list, or null if the list is empty.
     */
    public function __construct(public ?SNode $head = null, public ?SNode $tail = null)
    {
    }

    /**
     * Prints the values of the SNodes in the list.
     * 
     * Outputs the values of the SNodes in the list in order, separated by ' => '.
     */
    public function print()
    {
        $SNode = $this->head;

        while ($SNode) {
            echo $SNode->value;

            if ($SNode = $SNode->next) {
                echo " => ";
            }
        }

        echo "<br>";    
    }

    /**
     * Prepends a new SNode with the given value to the beginning of the list.
     * 
     * @param mixed $value The value to be stored in the new SNode.
     * @return SNode The newly created SNode.
     */
    public function prepend($value): self
    {
        $this->head = $SNode = new SNode($value, $this->head);
        $this->tail ??= $SNode; // Store SNode as tail if tail is empty.
        return $this;
    }

    /**
     * Inserts a new SNode with the given value after a specified SNode.
     *
     * @param mixed $value The value to be inserted.
     * @param SNode $after The SNode after which the new SNode will be inserted.
     * @return self The current instance of the SinglyLinkedList for method chaining.
     */
    public function insertAfter($value, SNode $after) : self
    {
        $after->next = $SNode = new SNode($value, $after->next);

        // Update tail if we append a new SNode after it.
        if ($after === $this->tail) {
            $this->tail = $SNode;
        }

        return $this;
    }

    /**
     * Appends a new SNode with the given value to the end of the linked list.
     *
     * @param mixed $value The value to be appended.
     * @return self The current instance of the SinglyLinkedList for method chaining.
     */
    public function append($value) : self
    {
        if(!$this->head)
        {
            $this->prepend($value);
        }

        $this->insertAfter($value, $this->tail);
        return $this;
    }


    /**
     * Removes and returns the first SNode (head) from the list.
     * 
     * If the list is empty, returns null.
     * 
     * @return SNode|null The SNode that was removed, or null if the list was empty.
     */
    public function shift() : ?SNode
    {
        if(!$SNode = $this->head)
        {
            return null;
        }

        if(!$this->head = $SNode->next)
        {
            $this->tail = null;
        }
        $SNode->next = null;
        return $SNode;
    }


    /**
     * Retrieves the value at the specified index in the linked list.
     *
     * @param int $index The zero-based index of the value to retrieve.
     * @return mixed The value at the specified index.
     * @throws \RuntimeException If the index is out of bounds.
     */
    public function get(int $index)
    {
        $SNode = $this->head;

        for($i = 0; $i < $index; $i++)
        {
            if(!$SNode) break;

            $SNode = $SNode->next;
        }

        if(!$SNode) throw new \RuntimeException(sprintf('A value with index:"%d" does not exist in the list.', $index));

        return $SNode->value;
    
    }


    /**
     * Removes a specified SNode from the linked list.
     * 
     * @param SNode $remove The SNode to be removed.
     * @return SNode The removed SNode.
     */
    public function remove(SNode $remove): SNode
    {
        $SNode = $this->head;

        // Traverse the list until the SNode just before the SNode to be removed
        while ($SNode && $SNode->next !== $remove) {
            $SNode = $SNode->next;
        }

        // Remove the SNode
        $SNode->next = $remove->next; // Rewire pointers to bypass the removed SNode
        $remove->next = null; // Clean up references

        // Update tail if the removeing the tail
        if ($remove === $this->tail) {
            $this->tail = $SNode;
        }
        

        return $remove; // Return the removed SNode
    }
}

// Example usage
$sgl = new SinglyLinkedList();

// Chaining method
$sgl->prepend('C')
    ->prepend('B')
    ->append('A')
    ->print(); // C => B => A

// Traverse to C to use the following function.
$sgl->insertAfter('X', $sgl->head);
$sgl->print();

// Shift Example
$shiftedSNode = $sgl->shift();
if ($shiftedSNode) {
    echo "Shifted SNode: " . $shiftedSNode->value . "<br>"; // Outputs 'Shifted SNode: C'
}

// Get Example
try {
    $value = $sgl->get(1); // Should retrieve the value 'B'
    echo "Value at index 1: " . $value . "<br>";
} catch (\RuntimeException $e) {
    echo $e->getMessage() . "<br>";
}

// Remove Function
// Removing SNode A (tail)
$removedSNode = $sgl->remove($sgl->head->next->next);
echo "Removed SNode: " . $removedSNode->value . "<br>";

// Prepend a new head SNode
$sgl->prepend("new head SNode");

// Append a new tail SNode
$sgl->append("this is tail");

// Print the whole class
echo "<pre>" . print_r($sgl, true) . "</pre>";




// Explanation:
// Chaining Method:
//      Prepend 'C' and 'B' to the list and append 'A'. Then print the list.
// Insert After:
//      Insert 'X' after 'C' and print the updated list.
// Shift Example:
//      Shift the head SNode and print the shifted SNode's value.
// Get Example:
//      Retrieve the value at index 1 ('B') and print it.
// Remove Function:
//      Remove the SNode 'A' from the list and print the removed SNode's value.
// Prepend and Append:
//      Prepend a new head SNode and append a new tail SNode.
// Print the Whole Class:
//      Print the entire SinglyLinkedList object to see its current state.

?>