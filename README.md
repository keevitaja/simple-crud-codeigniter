#Simple database CRUD for Codeigniter

* by Tanel Tammik - keevitaja@gmail.com
* PHP 5.3 required

##Description

Simple CRUD is very simple (it really cannot be more simpler) "database abstraction
layer" for CodeIgniter, which gives you some additional benefits.

## Setup

To create a new model extend it from Simple_crud instead of CI_Model.
Both Simple_crud and your model must be loaded in CI way.

Name your models <Table_name>_model. If you do not like "_model" in all
model names, just remove preg_replace from __construct() method. If table
name is example, then model would look

<pre><code>class Example_model extends Simple_crud {}</pre></code>

### Usage examples

Table: example
Fields: id, cats, dogs
Model: Example_model

<pre><code>// Insert a row:

$pets = new Example_model;
$pets->cats = 'Jerry';
$pets->dogs = 'Spike';
$pets->create(); // on success returns insert_id()</code></pre>

<pre><code>// Fetch a row:

$pets = Example_model::get($id); // where $id is the primary key
// or
$pets = Example_model::get(array('dogs' => 'Spike'));</code></pre>

<pre><code>// Update a row:

$pets = Example_model::get($id);
$pets->dogs = 'Harry';
$pets->update();</code></pre>

<pre><code>// Delete a row:

$pets = Example_model::get($id);
$pets->delete();
// or
$this->example_model->delete($id); // where $id id the primary key</code></pre>

<pre><code>// All together: create, update and delete. lol

$pets = new Example_model;
$pets->cats = 'cat';
$pets->dogs = 'dog';
$pets = Example_model::get($pets->create()); // new row created and fetched. wtf
$pets->cats = 'jerry';
$pets->update(); // row updated
$pets->delete(); // row deleted

// In just 7 lines we created new row, updated and deleted it!</code></pre>

In Example_model you can add your own custom methods as it was the
regular CodeIgniter model.