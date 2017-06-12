import random
import time
import sys
import argparse

class AVLTree(object):
	def __init__(self):
		self.root = None

		class __Node(object):
			def __init__(self, key):
				print(key)
				self.key = key
				self.right = None
				self.left = None
				self.height = 1

				def __bfactor(self, node):
					return self.__height(node.right) - self.__height(node.left)

					def insertKey(self, key):
						self.root = self.__insert(self.root, key)

						def __insert(self, node, key):
							if node == None:
							node = self.__Node(key)
							return node
							if key == node.key:
							raise Exception("Key already in tree")

							if (key < node.key):
#			print key, node.key
								node.left = self.__insert(node.left, key)
	else:
	node.right = self.__insert(node.right, key)
return self.__balance(node)

	def __fixheight(self, node):
		node.height = max(self.__height(node.right), self.__height(node.left)) + 1

		def __height(self, node):
			if node != None:
			return node.height
			else:
			return 0

			def __rotateLeft(self, node):
				p = node.right
				node.right = p.left
	p.left = node
	self.__fixheight(p)
	   self.__fixheight(node)
	   return p

	   def __rotateRight(self, node):
		   q = node.left
		   node.left = q.right
	q.right = node
	self.__fixheight(node)
	    self.__fixheight(q)
	    return q

	    def __balance(self, node):
		    self.__fixheight(node)
		    if self.__bfactor(node) == 2:
		    if self.__bfactor(node.right) < 0:
	node.right = self.__rotateRight(node.right)
	     return self.__rotateLeft(node)

	     if self.__bfactor(node) == -2:
	node.left = self.__rotateLeft(node.left)
return self.__rotateRight(node)
	return node










tree = AVLTree()
	for i in range(1,100):
		tree.insertKey(i)


