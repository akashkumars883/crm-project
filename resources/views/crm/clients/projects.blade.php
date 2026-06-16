@extends('layouts.app')
@section('title', 'My Projects')
@section('content')
<style>
/* Premium Crisp Minimalist Design */
.proj-page { background: transparent; min-height: 100vh; padding: 24px 16px 90px; font-family: 'Inter', system-ui, sans-serif; }
.proj-card { 
    background: #ffffff; 
    border-radius: 4px !important; 
    border: 1px solid #e9ecef !important; 
    box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important; 
    margin-bottom: 20px; 
    overflow: hidden; 
}
.proj-header { 
    padding: 16px 20px; 
    border-bottom: 1px solid #f1f3f5 !important; 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    background: #ffffff; 
}
.proj-name { font-size: 16px; font-weight: 700; color: #212529; margin-bottom: 4px; }
.proj-id { font-size: 13px; color: #6c757d; font-weight: 500; }
.proj-body { padding: 20px; }
.proj-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px; }
.proj-cell { 
    background: #f8f9fa; 
    border: 1px solid #f1f3f5;
    border-radius: 4px !important; 
    padding: 12px 16px; 
}
.proj-cell-label { font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; margin-bottom: 4px;}
.proj-cell-val { font-size: 14px; font-weight: 700; color: #212529; }
.proj-bar { height: 6px; background: #f1f3f5; border-radius: 4px !important; overflow: hidden; margin: 8px 0 20px; }
.proj-bar-fill { height: 100%; background: #0d6efd; border-radius: 4px !important; transition: width 0.5s ease; }
.proj-bar-info { display: flex; justify-content: space-between; font-size: 13px; color: #495057; font-weight: 600; margin-bottom: 4px; }
.proj-btn { 
    display: block; 
    text-align: center; 
    background: #f8f9fa; 
    color: #0d6efd; 
    border: 1px solid #dee2e6;
    padding: 10px; 
    border-radius: 4px !important; 
    text-decoration: none; 
    font-weight: 600; 
    font-size: 13px; 
    transition: all 0.2s ease;
}
.proj-btn:hover { background: #0d6efd; color: #ffffff; border-color: #0d6efd; }
.proj-status { display: inline-block; padding: 4px 10px; border-radius: 4px !important; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;}
.proj-status.active { background: #e8f4fd; color: #0d6efd; border: 1px solid #cfe2ff !important; }
.proj-status.pending { background: #fff8e6; color: #fd7e14; border: 1px solid #ffe69c !important; }
.proj-status.completed { background: #eefaf3; color: #198754; border: 1px solid #d1e7dd !important; }
.empty-state { text-align: center; padding: 60px 20px; color: #6c757d; }

@media (max-width: 768px) {
  .proj-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<div class="proj-page">
  <h4 class="mb-4" style="color:#212529;font-weight:700;"><i class="ti ti-building-skyscraper text-primary"></i> My Projects</h4>

  @forelse($projects as $project)
    @php
      $statusName = strtolower($project->projectStatus->name ?? 'active');
      $statusCls = 'active';
      if(str_contains($statusName,'complete') || str_contains($statusName,'done')) $statusCls='completed';
      elseif(str_contains($statusName,'hold') || str_contains($statusName,'pending')) $statusCls='pending';
      $progress = $project->progress_percent ?? 0;
    @endphp
    <div class="proj-card">
      <div class="proj-header">
        <div class="d-flex justify-content-between align-items-start w-100" style="display:flex;justify-content:space-between;align-items:center;">
          <div>
            <div class="proj-name">{{ $project->name ?? 'Project #'.$project->id }}</div>
            <div class="proj-id"><i class="ti ti-calendar text-muted"></i> {{ $project->start_date ? $project->start_date->format('d M Y') : 'N/A' }} @if($project->end_date) → {{ $project->end_date->format('d M Y') }} @endif</div>
          </div>
          <span class="proj-status {{ $statusCls }}">{{ $project->projectStatus->name ?? 'Active' }}</span>
        </div>
      </div>
      <div class="proj-body">
        <div class="proj-grid">
          <div class="proj-cell">
            <div class="proj-cell-label">Type</div>
            <div class="proj-cell-val">{{ $project->projectType->name ?? 'N/A' }}</div>
          </div>
          <div class="proj-cell">
            <div class="proj-cell-label">Total Area</div>
            <div class="proj-cell-val">{{ $project->total_area ?? 'N/A' }} sq.ft</div>
          </div>
          <div class="proj-cell">
            <div class="proj-cell-label">Estimated Cost</div>
            <div class="proj-cell-val text-primary">₹ {{ number_format($project->estimated_cost ?? 0, 0) }}</div>
          </div>
          <div class="proj-cell">
            <div class="proj-cell-label">Final Cost</div>
            <div class="proj-cell-val text-success">₹ {{ number_format($project->final_cost ?? 0, 0) }}</div>
          </div>
        </div>
        @if($project->description)
          <p style="font-size:14px;color:#495057;margin-bottom:16px;">{{ Str::limit($project->description, 150) }}</p>
        @endif
        <div class="proj-bar-info"><span>Overall Progress</span><span class="text-primary">{{ $progress }}%</span></div>
        <div class="proj-bar"><div class="proj-bar-fill" style="width:{{ $progress }}%"></div></div>
        <a href="{{ route('myProjectShow', $project->id) }}" class="proj-btn"><i class="ti ti-eye"></i> View Full Details</a>
      </div>
    </div>
  @empty
    <div class="proj-card empty-state">
      <i class="ti ti-building-skyscraper" style="font-size:60px;opacity:.3;margin-bottom:16px;"></i>
      <h5 class="mt-3 text-dark fw-bold">No projects yet</h5>
      <p>Once your project starts, it will appear here.</p>
    </div>
  @endforelse

  <div class="mt-4">{{ $projects->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
