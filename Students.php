<?php
declare(strict_types=1);

class Student
{
    public string $firstName;
    public string $lastName;
    /** @var float[]|int[] */
    public array $grades = [];

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function addGrade(int|float $grade): void
    {
        $this->grades[] = $grade;
    }

    public function getAverage(): float
    {
        if (count($this->grades) === 0) {
            return 0.0;
        }
        return array_sum($this->grades) / count($this->grades);
    }
}

class Group
{
    public string $groupName;
    /** @var Student[] */
    public array $students = [];

    public function __construct(string $groupName)
    {
        $this->groupName = $groupName;
    }

    public function addStudent(Student $student): void
    {
        $this->students[] = $student;
    }

    public function getGroupAverage(): float
    {
        if (count($this->students) === 0) {
            return 0.0;
        }
        $sum = 0.0;
        foreach ($this->students as $student) {
            $sum += $student->getAverage();
        }
        return $sum / count($this->students);
    }

    public function getBestStudent(): ?Student
    {
        $best = null;
        foreach ($this->students as $student) {
            if ($best === null || $student->getAverage() > $best->getAverage()) {
                $best = $student;
            }
        }
        return $best;
    }
}

function printStudentInfo(Student $student): void
{
    echo "Студент: {$student->firstName} {$student->lastName}, "
        . "средний балл: " . number_format($student->getAverage(), 2) . PHP_EOL;
}

function printGroupInfo(Group $group): void
{
    echo "Группа: {$group->groupName}" . PHP_EOL;
    echo "Количество студентов: " . count($group->students) . PHP_EOL;
    echo "Общий средний балл: " . number_format($group->getGroupAverage(), 2) . PHP_EOL;
}

$ivan = new Student('Иван', 'Петров');
foreach ([5, 4, 5, 5] as $g) {
    $ivan->addGrade($g);
}

$anna = new Student('Анна', 'Сидорова');
foreach ([4, 4, 3, 5] as $g) {
    $anna->addGrade($g);
}

$oleg = new Student('Олег', 'Кузнецов');
foreach ([3, 4, 4, 3] as $g) {
    $oleg->addGrade($g);
}

$group = new Group('ИС-21');
$group->addStudent($ivan);
$group->addStudent($anna);
$group->addStudent($oleg);

echo "=== Студенты ===" . PHP_EOL;
foreach ($group->students as $student) {
    printStudentInfo($student);
}

echo PHP_EOL . "=== Группа ===" . PHP_EOL;
printGroupInfo($group);

echo PHP_EOL . "=== Лучший студент ===" . PHP_EOL;
$best = $group->getBestStudent();
if ($best !== null) {
    printStudentInfo($best);
}