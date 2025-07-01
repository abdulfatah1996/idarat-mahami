<?php

namespace App\Livewire\Project;

use App\Exports\ProjectsExport;
use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;


#[Title('المشاريع المنشأة')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public User $user;
    public $selectedId;
    public $justDeletedId;


    #[Url]
    public $search = '';

    public $sortColumn = 'created_at';
    public $sortDirection = false; // false = desc, true = asc

    public bool $showToast = false;
    public string $message = '';
    public string $type = 'success';


    public $filterStatus = '';
    public $filterPriority = '';

    public bool $showDeleteModal = false;


    public $selectedProjects = [];
    public $selectAll = false; // للتحكم في تحديد الكل

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function showToast(string $message, string $type = 'success')
    {
        $this->message = $message;
        $this->type = $type;
        $this->showToast = true;
    }

    public function hideToast()
    {
        $this->showToast = false;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = !$this->sortDirection;
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = false; // desc افتراضي
        }

        $this->resetPage(); // تحديث مباشر
    }

    protected function applySearch($query)
    {
        if ($this->search) {
            $searchTerm = $this->search;

            $translatedStatus = match (trim($searchTerm)) {
                'جديد' => 'new',
                'قيد التنفيذ' => 'in_progress',
                'مكتمل' => 'completed',
                default => null,
            };

            $query->where(function ($q) use ($searchTerm, $translatedStatus) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('number', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhere('status', 'like', '%' . ($translatedStatus ?? $searchTerm) . '%')
                    ->orWhereHas('owner', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('email', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterPriority) {
            $query->where('priority', $this->filterPriority);
        }
    }


    protected function applySort($query)
    {
        if ($this->sortColumn) {
            $column = match ($this->sortColumn) {
                'name', 'status', 'number', 'start_date', 'end_date', 'created_at' => $this->sortColumn,
                default => 'created_at',
            };

            $query->orderBy($column, $this->sortDirection ? 'asc' : 'desc');
        }

        return $query;
    }

    public function deleteProject()
    {
        $project = Project::find($this->selectedId);

        if ($project) {
            $this->justDeletedId = $project->id; // لتلوين الصف مؤقتاً
            $project->delete();
            $this->showToast('تم حذف المشروع بنجاح', 'success');
        }
    }

    public function exportExcel()
    {
        $query = $this->user->projects();
        $this->applySearch($query); // تطبق الفلترة
        $this->applySort($query);   // تطبق الترتيب

        $projects = $query->get(); // اجلب البيانات (بدون paginate)

        //create the filename with current date and time
        $filename = 'projects_' . now()->format('Y_m_d_H_i_s') . '.xlsx';

        return Excel::download(new ProjectsExport($projects), $filename);
    }


    // تحديد جميع المشاريع
    public function selectAllProjects()
    {
        if ($this->selectAll) {
            $this->selectedProjects = $this->user->projects()->pluck('id')->toArray();
        } else {
            $this->selectedProjects = [];
        }
    }

    // تحديث حالة تحديد الكل
    public function updatedSelectAll()
    {
        $this->selectAllProjects();
    }


    // حذف المشاريع المحددة
    public function deleteSelected()
    {
        if (empty($this->selectedProjects)) {
            $this->showToast('يرجى تحديد مشاريع لحذفها', 'warning');
            return;
        }

        Project::whereIn('id', $this->selectedProjects)->delete();

        $this->selectedProjects = []; // ✅ إلغاء التحديد بعد الحذف

        $this->showDeleteModal = false; // إغلاق النافذة المنبثقة
        $this->selectAll = false; // إعادة تعيين تحديد الكل
        $this->showToast('تم حذف المشاريع المحددة بنجاح', 'success');
    }

    // تأكيد حذف المشاريع المحددة
    public function confirmDelete()
    {
        if (empty($this->selectedProjects)) {
            $this->showToast('يرجى تحديد مشاريع لحذفها', 'warning');
            return;
        }

        $this->showDeleteModal = true;
    }

    public function render()
    {
        $query = $this->user->projects();
        $this->applySearch($query);
        $this->applySort($query);

        return view('livewire.project.index', [
            'projects' => $query->paginate(6),
        ]);
    }
}
