<?php

/**
 * Class CNode
 * 
 * Represents a node in a circular doubly linked list.
 */
class CNode {

    /**
     * Cnode constructor.
     * 
     * @param mixed $value The value to be stored in the node.
     * @param CNode|null $prev The previous node in the list, or null if there is no previous node.
     * @param CNode|null $next The next node in the list, or null if there is no next node.
     */
    public function __construct(
        public $value, 
        public ?CNode $prev = null,
        public ?CNode $next = null)
    {
    }
}


/**
 * 
 * Diagram:
 *      
 *    _____________________________________________
 *    |                                           | 
 *    *                                           *
 * [Head] <=> [Node 1] <=> [Node 2] <=> ... <=> [Tail]
 *  
 */



/**
 * Class CircularDoublyLinkedList
 * 
 * Represents a class in a circular doubly linked list.
 */
class CircularDoublyLinkedList
{
    /**
     * CircularDoublyLinkedList constructor.
     * Initializes an empty list with head and tail set to null.
     */
    public function __construct(
        public ?CNode $head=null,
        public ?CNode $tail=null,
    ){ }

    /**
     * Prints the values of the nodes in the list.
     * 
     * Outputs the values of the nodes in the list in order, separated by ' <=> '.
     */
    public function print()
    {
        if (!$this->head) {
            echo "List is empty.<br>";
            return;
        }

        $currentNode = $this->head;
        $diagram = '';

        do {
            if($currentNode->prev) 
            {
                $diagram .= " (pr:{$currentNode->prev->value}])";
            }
            
            $diagram .= " [node:{$currentNode->value}] ";

            if ($currentNode->next) {
                $diagram .= " (ne:{$currentNode->next->value})";
            }
            if ($currentNode->next !== $this->head) {
                $diagram .= " <=> ";
            }
            $currentNode = $currentNode->next;
        } while ($currentNode !== $this->head);

        echo $diagram . "<br>";
       
    }

    /**
     * Prepends a new node with the given value to the beginning of the list.
     * 
     * @param mixed $value The value to be stored in the new node.
     * @return self The current instance of the CircularDoublyLinkedList for method chaining.
     */
    public function prepend($value) : self 
    {
        $newNode = new CNode($value);
        
        if(!$this->head)
        {
            $this->head = $this->tail = $newNode;
            $this->head->next = $this->head->prev = $newNode;
        }
        else
        {
            $newNode->next = $this->head;
            $newNode->prev = $this->tail;   
            $this->head->prev= $newNode;
            $this->tail->next= $newNode;
            $this->head = $newNode;
        }

        return $this;
    }

    /**
     * Appends a new node with the given value to the end of the list.
     * 
     * @param mixed $value The value to be stored in the new node.
     * @return self The current instance of the CircularDoublyLinkedList for method chaining.
     */
    public function append($value) : self
    {
        $newNode = new CNode($value);
        if (!$this->head) {
            $this->head = $this->tail = $newNode;
            $this->head->next = $this->head->prev = $newNode;
        }
        else{

            // rewire
            $newNode->prev = $this->tail;
            $newNode->next = $this->head;
            $this->tail->next = $newNode;
            $this->head->prev = $newNode;
            $this->tail = $newNode;
        }

        return $this;
    }

    /**
     * Get the node with the specified value.
     * 
     * @param mixed $value The value to search for.
     * @return Cnode|null The node with the specified value, or null if not found.
     */
    public function getNodeByValue($value) : ?CNode
    {
        if ($value === null || !$this->head) return null;

        $currentNode = $this->head;

        // Traverse the list until the node with the specified value is found or the end of the list.
        do {
            if ($currentNode->value === $value) {
                return $currentNode; // Return the node if its value matches the specified value.
            }
            $currentNode = $currentNode->next;
        } while ($currentNode !== $this->head);

        return null; // If the value is not found in any node, return null.
    }

    /**
     * Remove the specified node from the list.
     * 
     * @param Cnode $node The node to be removed.
     * @return void
     */
    public function remove(CNode $node) : ?CNode
    {   
        if(!$node) return null;
        if($this->head === $node && $this->tail === $node)
        {
            $this->head = $this->tail = null;
        }
        else if($this->head === $node)
        {
            $this->head = $node->next;
            $this->tail->prev = $this->head;
            $this->head->prev = $this->tail;
        }
        else if($this->tail == $node)
        {
            $this->tail = $this->tail->prev;
            $this->head->prev = $this->tail;
            $this->tail->next = $this->head;
        }
        else
        {
            $node->prev->next = $node->next;
            $node->next->prev = $node->prev;
        }

        return $node;
    }

    public function insertAt($value,CNode $prev): ?CNode
    {
        if (!$value) return null;

        $newNode = new CNode($value, $prev, $prev->next);
        $prev->next = $newNode;
        $newNode->next->prev= $newNode;

        return $newNode;
    }
}

$cll = new CircularDoublyLinkedList();

$cll->prepend("A")
    ->prepend("B")
    ->prepend("C");

$cll->append("tail1");

$nodeB = $cll->getNodeByValue("tail1");

$cll->insertAt("extend", $nodeB);

// $cll->remove($nodeB);

$cll->print();

// echo "<pre>" . print_r($nodeB, true) . "</pre>";
echo "<pre>" . print_r($cll, true) . "</pre>";

?>