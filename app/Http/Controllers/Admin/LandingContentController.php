<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureCard;
use App\Models\LandingSection;
use App\Models\ProcessStep;
use Illuminate\Http\Request;

class LandingContentController extends Controller
{
    public const ICONS = ['map-pin', 'credit-card', 'camera', 'pen-line', 'compass', 'globe', 'users', 'shield-check', 'heart', 'star', 'upload-cloud', 'calendar'];

    public const COLORS = ['brand', 'coral', 'teal', 'purple'];

    public function index()
    {
        return view('admin.landing.index', [
            'sections' => LandingSection::all()->keyBy('key'),
            'featureCards' => FeatureCard::orderBy('position')->get(),
            'processSteps' => ProcessStep::orderBy('position')->get(),
            'icons' => self::ICONS,
            'colors' => self::COLORS,
        ]);
    }

    public function updateSections(Request $request)
    {
        $data = $request->validate([
            'sections' => ['required', 'array'],
            'sections.*.badge' => ['nullable', 'string', 'max:255'],
            'sections.*.title' => ['nullable', 'string', 'max:255'],
            'sections.*.subtitle' => ['nullable', 'string'],
        ]);

        foreach ($data['sections'] as $key => $fields) {
            LandingSection::updateOrCreate(['key' => $key], $fields);
        }

        return back()->with('success', 'Landing page content updated.');
    }

    public function storeFeatureCard(Request $request)
    {
        $data = $request->validate([
            'icon' => ['required', 'string', 'in:'.implode(',', self::ICONS)],
            'color_key' => ['required', 'string', 'in:'.implode(',', self::COLORS)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        FeatureCard::create($data);

        return back()->with('success', 'Feature card added.');
    }

    public function updateFeatureCard(Request $request, FeatureCard $featureCard)
    {
        $data = $request->validate([
            'icon' => ['required', 'string', 'in:'.implode(',', self::ICONS)],
            'color_key' => ['required', 'string', 'in:'.implode(',', self::COLORS)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $featureCard->update($data);

        return back()->with('success', 'Feature card updated.');
    }

    public function destroyFeatureCard(FeatureCard $featureCard)
    {
        $featureCard->delete();

        return back()->with('success', 'Feature card removed.');
    }

    public function storeProcessStep(Request $request)
    {
        $data = $request->validate([
            'icon' => ['required', 'string', 'in:'.implode(',', self::ICONS)],
            'color_key' => ['required', 'string', 'in:'.implode(',', self::COLORS)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        ProcessStep::create($data);

        return back()->with('success', 'Step added.');
    }

    public function updateProcessStep(Request $request, ProcessStep $processStep)
    {
        $data = $request->validate([
            'icon' => ['required', 'string', 'in:'.implode(',', self::ICONS)],
            'color_key' => ['required', 'string', 'in:'.implode(',', self::COLORS)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $processStep->update($data);

        return back()->with('success', 'Step updated.');
    }

    public function destroyProcessStep(ProcessStep $processStep)
    {
        $processStep->delete();

        return back()->with('success', 'Step removed.');
    }
}
