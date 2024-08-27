<?php

/**
 * Represents a node in a binary search tree (BST).
 */
class TreeNode
{
    /**
     * Constructs a new TreeNode.
     *
     * @param mixed $value The value of the node.
     * @param TreeNode|null $left The left child node.
     * @param TreeNode|null $right The right child node.
     */
    public function __construct(
        public $value,
        public ?TreeNode $left = null,
        public ?TreeNode $right = null
    ) {}
}

/**
 * Implements a binary search tree with insertion, searching, deletion, and printing operations.
 */
class BinarySearchTree
{
    public ?TreeNode $root = null;

    /**
     * Creates a new node or inserts a value in the correct position.
     *
     * @param TreeNode|null $node The current node.
     * @param mixed $value The value to insert.
     * @return TreeNode The newly created or updated node.
     */
    private function createNode(?TreeNode $node, $value): TreeNode
    {
        if ($node === null) return new TreeNode($value);

        if ($value < $node->value) {
            $node->left = $this->createNode($node->left, $value);
        } else {
            $node->right = $this->createNode($node->right, $value);
        }
        return $node;
    }

    /**
     * Inserts a value into the BST.
     *
     * @param mixed $value The value to insert.
     * @return self The current instance for method chaining.
     */
    public function insert($value): self
    {
        $this->root = $this->createNode($this->root, $value);
        return $this;
    }

    /**
     * Deletes a node with a specific value from the BST.
     *
     * @param TreeNode|null $root The current root node.
     * @param mixed $value The value of the node to delete.
     * @return TreeNode|null The new root node.
     */
    private function deleteNode(?TreeNode $root, $value): ?TreeNode
    {
        if (!$root) return null;

        if ($value < $root->value) {
            $root->left = $this->deleteNode($root->left, $value);
        } else if ($value > $root->value) {
            $root->right = $this->deleteNode($root->right, $value);
        } else {
            // Node with only one child or no child
            if ($root->left === null) {
                return $root->right;
            } elseif ($root->right === null) {
                return $root->left;
            }

            // Node with two children: Get the inorder successor (smallest in the right subtree)
            $minValue = $this->findMinValue($root->right);
            $root->value = $minValue;
            $root->right = $this->deleteNode($root->right, $minValue);
        }

        return $root;
    }

    /**
     * Finds the minimum value in a subtree.
     *
     * @param TreeNode|null $node The root of the subtree.
     * @return mixed The minimum value.
     */
    private function findMinValue(?TreeNode $node)
    {
        $current = $node;
        while ($current && $current->left !== null) {
            $current = $current->left;
        }
        return $current->value;
    }

    /**
     * Removes a node with a specific value from the BST.
     *
     * @param mixed $value The value to remove.
     * @return self The current instance for method chaining.
     */
    public function remove($value): self
    {
        $this->root = $this->deleteNode($this->root, $value);
        return $this;
    }

    /**
     * Searches for a node with a specific value and returns its details.
     *
     * @param mixed $value The value to search for.
     * @return array|null Details about the node or null if not found.
     */
    public function searchWithDetails($value): ?array
    {
        return $this->searchNodeWithDetails($this->root, $value, 0);
    }

    /**
     * Searches for a node with a specific value and provides details about its position.
     *
     * @param TreeNode|null $node The current node.
     * @param mixed $value The value to search for.
     * @param int $level The current level in the tree.
     * @param string|null $parentSide Indicates if the node is a left or right child.
     * @return array|null Details about the node or null if not found.
     */
    private function searchNodeWithDetails(?TreeNode $node, $value, int $level, ?string $parentSide = null): ?array
    {
        if ($node === null) {
            return null; // Node not found
        }

        if ($value < $node->value) {
            return $this->searchNodeWithDetails($node->left, $value, $level + 1, 'left');
        } elseif ($value > $node->value) {
            return $this->searchNodeWithDetails($node->right, $value, $level + 1, 'right');
        } else {
            // Node found
            return [
                'value' => $node->value,
                'level' => $level,
                'parentSide' => $parentSide
            ];
        }
    }

    /**
     * Prints the tree structure in a formatted manner.
     *
     * @param TreeNode|null $node The current node.
     * @param int $level The level of the current node.
     * @param string $prefix The prefix for the current level.
     * @return void
     */
    public function printTree(?TreeNode $node, int $level = 0, string $prefix = ""): void
    {
        if ($node !== null) {
            // Print the current node
            echo str_repeat(" ", $level * 4) . $prefix . $node->value . "<br>";

            // Print right child first (higher level)
            $this->printTree($node->right, $level + 1, "/ ");

            // Print left child (lower level)
            $this->printTree($node->left, $level + 1, "\\ ");
        }
    }
}

// Example usage
$bst = new BinarySearchTree();
$bst->insert(8)
    ->insert(3)
    ->insert(10)
    ->insert(2)
    ->insert(7)
    ->insert(14)
    ->insert(4)
    ->insert(13);

// Uncomment to remove a node
// $bst->remove(3);

echo "<pre>";
$bst->printTree($bst->root);
echo "</pre>";

$valueToSearch = 7;
echo "<br>Searching for $valueToSearch with details:<br>";
$searchResult = $bst->searchWithDetails($valueToSearch);
if ($searchResult !== null) {
    echo "Value: " . $searchResult['value'] . "<br>";
    echo "Level: " . $searchResult['level'] . "<br>";
    echo "Parent Side: " . $searchResult['parentSide'] . "<br>";
} else {
    echo "$valueToSearch is not present in the tree.<br>";
}
