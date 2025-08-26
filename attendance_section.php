<?php
$students = $student->getStudents();
$editingStudent = null;

if ($action === 'edit' && $type === 'student') {
    $editingStudent = $student->getStudent($_GET['id'])[0] ?? null;
}
?>

<div class="card">
    <h2><?= $editingStudent ? 'Edit Student' : 'Add New Student' ?></h2>
    <form method="POST" action="index.php?action=<?= $editingStudent ? 'edit' : 'add' ?>&type=student">
        <?php if ($editingStudent): ?>
            <input type="hidden" name="id" value="<?= $editingStudent['id'] ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label>Student ID:</label>
            <input type="text" name="student_id" value="<?= $editingStudent['student_id'] ?? '' ?>" required>
        </div>
        
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="first_name" value="<?= $editingStudent['first_name'] ?? '' ?>" required>
        </div>
        
        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="last_name" value="<?= $editingStudent['last_name'] ?? '' ?>" required>
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?= $editingStudent['email'] ?? '' ?>" required>
        </div>
        
        <div class="form-group">
            <label>Course:</label>
            <input type="text" name="course" value="<?= $editingStudent['course'] ?? '' ?>" required>
        </div>
        
        <div class="form-group">
            <label>Year Level:</label>
            <input type="number" name="year_level" value="<?= $editingStudent['year_level'] ?? '' ?>" min="1" required>
        </div>
        
        <button type="submit" class="btn btn-primary"><?= $editingStudent ? 'Update' : 'Add' ?> Student</button>
        <?php if ($editingStudent): ?>
            <a href="index.php?section=students" class="btn">Cancel</a>
        <?php endif; ?>
    </form>
</div>

<div class="card">
    <h2>Student List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Year</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $s): ?>
            <tr>
                <td><?= $s['id'] ?></td>
                <td><?= $s['student_id'] ?></td>
                <td><?= $s['first_name'] . ' ' . $s['last_name'] ?></td>
                <td><?= $s['email'] ?></td>
                <td><?= $s['course'] ?></td>
                <td><?= $s['year_level'] ?></td>
                <td>
                    <a href="index.php?section=students&action=edit&type=student&id=<?= $s['id'] ?>" class="btn btn-primary">Edit</a>
                    <a href="index.php?section=students&action=delete&type=student&id=<?= $s['id'] ?>" 
                       class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
