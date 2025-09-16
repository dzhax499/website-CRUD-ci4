<?php 
namespace App\Models;
use CodeIgniter\Model;

class User_model extends Model
{
    protected $table = 'biodata';
    protected $primaryKey = 'nim';
    protected $allowedFields = [
            'nim',
            'nama_lengkap',
            'jurusan',
            'username',
            'password',
            'role',
            'email',
            'semester',
            'enrolled_courses',
            'status',
            'created_at',
            'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'create_at';
    protected $updatedField = 'updated_at';
    // method

    public function authenticate($username , $password)
    {
        $user = $this->where('username', $username)->where('role =/','course')->first();

        if ($user && password_verify($password, $user['password'])) 
        {
            return $user;
        }
        return false;
    }
    // Method untuk mendapatkan semua students
    public function getStudents()
    {
        return $this->where('role', 'student')
            ->where('status', 'active')
            ->findAll();
    }

    // Method untuk mendapatkan semua courses
    public function getCourses()
    {
        return $this->where('role', 'course')
            ->where('status', 'active')
            ->findAll();
    }

    // Method untuk enrollment course
    public function enrollCourse($studentNim, $courseCode)
    {
        $student = $this->where('nim', $studentNim)->where('role', 'student')->first();

        if ($student) {
            $enrolledCourses = json_decode($student['enrolled_courses'] ?? '[]', true);

            // Cek apakah sudah terdaftar
            if (!in_array($courseCode, $enrolledCourses)) {
                $enrolledCourses[] = $courseCode;

                return $this->update($student['nim'], [
                    'enrolled_courses' => json_encode($enrolledCourses)
                ]);
            }
        }
        return false;
    }

    // Method untuk unenroll course
    public function unenrollCourse($studentNim, $courseCode)
    {
        $student = $this->where('nim', $studentNim)->where('role', 'student')->first();

        if ($student) {
            $enrolledCourses = json_decode($student['enrolled_courses'] ?? '[]', true);
            $enrolledCourses = array_filter($enrolledCourses, function ($course) use ($courseCode) {
                return $course !== $courseCode;
            });

            return $this->update($student['nim'], [
                'enrolled_courses' => json_encode(array_values($enrolledCourses))
            ]);
        }
        return false;
    }

    // Method untuk mendapatkan courses yang diambil student
    public function getStudentEnrollments($studentNim)
    {
        $student = $this->where('nim', $studentNim)->where('role', 'student')->first();

        if ($student && $student['enrolled_courses']) {
            $enrolledCodes = json_decode($student['enrolled_courses'], true);

            if (!empty($enrolledCodes)) {
                return $this->whereIn('nim', $enrolledCodes)
                    ->where('role', 'course')
                    ->findAll();
            }
        }
        return [];
    }
}
?>