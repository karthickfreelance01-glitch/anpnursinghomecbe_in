<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Uploader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Shared create / edit / delete logic for Departments and Specialities.
 */
abstract class LandingCrudController extends Controller
{
    /** @return class-string<Model> */
    abstract protected function model(): string;
    abstract protected function folder(): string;       // uploads/<folder>
    abstract protected function routeBase(): string;    // admin.departments
    abstract protected function label(): string;        // Department

    protected function extraRules(?Model $item): array { return []; }
    protected function extraData(Request $r): array { return []; }

    protected function rules(?Model $item): array
    {
        $table = (new ($this->model()))->getTable();

        return array_merge([
            'name'              => ['required', 'string', 'max:150'],
            'slug'              => ['nullable', 'string', 'max:160', 'alpha_dash', Rule::unique($table, 'slug')->ignore($item?->id)],
            'icon'              => ['nullable', 'string', 'max:60', 'regex:/^bi-[a-z0-9-]+$/'],
            'tagline'           => ['nullable', 'string', 'max:200'],
            'short_description' => ['nullable', 'string', 'max:600'],
            'description'       => ['nullable', 'string'],
            'services'          => ['nullable', 'string', 'max:5000'],
            'faqs'              => ['nullable', 'array'],
            'faqs.*.q'          => ['nullable', 'string', 'max:300'],
            'faqs.*.a'          => ['nullable', 'string', 'max:2000'],
            'image'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'banner_image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'og_image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sort_order'        => ['nullable', 'integer', 'min:0', 'max:9999'],
            'meta_title'        => ['nullable', 'string', 'max:255'],
            'meta_description'  => ['nullable', 'string', 'max:500'],
            'meta_keywords'     => ['nullable', 'string', 'max:500'],
        ], $this->extraRules($item));
    }

    protected function fill(Request $r, ?Model $item = null): array
    {
        $v = $r->validate($this->rules($item), [
            'icon.regex' => 'Icon must be a Bootstrap Icons class such as bi-heart-pulse.',
        ]);

        $data = [
            'name'              => $v['name'],
            'slug'              => Str::slug($v['slug'] ?: $v['name']),
            'icon'              => $v['icon'] ?? null,
            'tagline'           => $v['tagline'] ?? null,
            'short_description' => $v['short_description'] ?? null,
            'description'       => $this->cleanHtml($v['description'] ?? ''),
            'services'          => collect(preg_split('/\r\n|\r|\n/', $v['services'] ?? ''))->map(fn ($s) => trim($s))->filter()->values()->all(),
            'faqs'              => collect($v['faqs'] ?? [])->filter(fn ($f) => filled($f['q'] ?? null) && filled($f['a'] ?? null))
                                        ->map(fn ($f) => ['q' => trim($f['q']), 'a' => trim($f['a'])])->values()->all(),
            'sort_order'        => (int) ($v['sort_order'] ?? 0),
            'is_active'         => $r->boolean('is_active'),
            'meta_title'        => $v['meta_title'] ?? null,
            'meta_description'  => $v['meta_description'] ?? null,
            'meta_keywords'     => $v['meta_keywords'] ?? null,
        ] + $this->extraData($r);

        foreach (['image', 'banner_image', 'og_image'] as $f) {
            if ($r->boolean("remove_{$f}")) {
                Uploader::delete($item?->{$f});
                $data[$f] = null;
            }
            if ($r->hasFile($f)) {
                $data[$f] = Uploader::store($r->file($f), $this->folder(), $item?->{$f});
            }
        }

        return $data;
    }

    /** Allow formatting tags from the editor, strip scripts / event handlers. */
    protected function cleanHtml(string $html): string
    {
        $html = strip_tags($html, '<p><br><strong><b><em><i><u><s><h2><h3><h4><ul><ol><li><a><blockquote><img><span><sub><sup>');
        $html = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
        $html = preg_replace('/(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*\2/i', '$1="#"', $html);

        return trim($html) === '<p><br></p>' ? '' : $html;
    }

    public function index(Request $r)
    {
        $q = ($this->model())::query()->ordered();
        if ($s = $r->get('q')) $q->where('name', 'like', "%{$s}%");
        $this->filterIndex($q, $r);

        return view('admin.landing.index', [
            'items' => $q->get(),
            'base'  => $this->routeBase(),
            'label' => $this->label(),
        ] + $this->indexExtras($r));
    }

    protected function filterIndex($q, Request $r): void {}
    protected function indexExtras(Request $r): array { return []; }

    public function create()
    {
        $item = new ($this->model())(['is_active' => true, 'show_in_menu' => true, 'category' => request('category', 'medical')]);
        $item->sort_order = ($this->model())::max('sort_order') + 1;

        return view('admin.landing.form', ['item' => $item, 'base' => $this->routeBase(), 'label' => $this->label()]);
    }

    public function store(Request $r)
    {
        $item = ($this->model())::create($this->fill($r));

        return redirect()->route($this->routeBase() . '.edit', $item)->with('ok', $this->label() . ' created. It is now live on the website.');
    }

    public function edit(string $id)
    {
        $item = ($this->model())::findOrFail($id);

        return view('admin.landing.form', ['item' => $item, 'base' => $this->routeBase(), 'label' => $this->label()]);
    }

    public function update(Request $r, string $id)
    {
        $item = ($this->model())::findOrFail($id);
        $item->update($this->fill($r, $item));

        return redirect()->route($this->routeBase() . '.edit', $item)->with('ok', $this->label() . ' saved.');
    }

    public function destroy(string $id)
    {
        $item = ($this->model())::findOrFail($id);
        foreach (['image', 'banner_image', 'og_image'] as $f) Uploader::delete($item->{$f});
        $item->delete();

        return redirect()->route($this->routeBase() . '.index')->with('ok', $this->label() . ' deleted.');
    }
}
