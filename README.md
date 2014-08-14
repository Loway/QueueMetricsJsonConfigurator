QueueMetrics Configuration Tools
================================

Prerequisites
-------------

Before using this software configurate it from ./includes/config.php

Make sure you have __php5-cli__, __php5-curl__ and __php5-json__ on your machine.

Description
-----------

These tools can be used to generate a back-up of the QueueMetrics configuration (Queues, Agents, Users, etc...) or integrated with your scripts and software.

queuemetrics-config-read.php
----------------------------

With this tool you can read all or some configurations from QueueMetrics.   
You will get the name of the kind of the element and its json value (encoded in base64 in order to have it on one line) separated by a tab; example:

agent	ewogICJhbGlhc2VzIiA6IC6ICAogICJjaGl...   
queue	iLAogICJjaGlewogICJhbGlhc26IC6ICCJa...   

Without parameters it will scan ALL the configurations, so that you can create a configuration dump or back-up:


#### Usage

./queuemetrics-config-read.php [parameters]   
or
./queuemetrics-config-read.php [parameters] > output-file

__-n__ or __--no-child__: prevents the script from looking for child elements (for hierarchical editors)   
__-e [name]__ or __--editor [name]__:	filter by name of the editor   
__-l [id]__ or __--element [id]__: filter a specific element by its ID (better used with __-e__)   
__-q [query]__ or __--query [query]__: filter by searching in elements' fields; use double quotes for more than one word   
__-p [parent id]__ or __--parent [parent id]__: filter by parent element's ID (for hierarchical editors, better used with __-e__)   
__-h__ or __--help__: will show this message 

queuemetrics-config-delete.php
------------------------------

With this tool you can delete all or some configurations from QueueMetrics.   
After an element is deleted, these script will output a copy of it.   
You will get the name of the kind of the element and its json value (encoded in base64 in order to have it on one line) separated by a tab; example:

agent	ewogICJhbGlhc2VzIiA6IC6ICAogICJjaGl...   
queue	iLAogICJjaGlewogICJhbGlhc26IC6ICCJa...

#### Warning

Be aware when deleting users or users classes, since this can prevent from accessing from QueueMetrics anymore.   
Also, if you delete your robot user or the ROBOTS user class the script stops working.

#### Usage

./queuemetrics-config-delete.php [parameters]
or
./queuemetrics-config-delete.php [parameters] > backup-file

__-n__ or __--no-child__: prevents the script from looking for child elements (for hierarchical editors)   
__-e [name]__ or __--editor [name]__:	filter by name of the editor   
__-l [id]__ or __--element [id]__: filter a specific element by its ID (better used with __-e__)   
__-q [query]__ or __--query [query]__: filter by searching in elements' fields; use double quotes for more than one word   
__-p [parent id]__ or __--parent [parent id]__: filter by parent element's ID (for hierarchical editors, better used with __-e__)   
__-f__ or __--force__: forces deleting; needed when you don't specify an element number   
__-h__ or __--help__: will show this message 

queuemetrics-config-add.php
---------------------------

Add a new QueueMetrics configuration from parameters or from file.

#### Usage

./queuemetrics-config-delete.php [editor name] [base64 encoded json object]
or
./queuemetrics-config-delete.php < input-file

Every line of input-file should be composed as [editor name] [base64 encoded json object], e.g:

agent	ewogICJhbGlhc2VzIiA6IC6ICAogICJjaGl...   
queue	iLAogICJjaGlewogICJhbGlhc26IC6ICCJa...  

__-h__ or __--help__: will show this message 
