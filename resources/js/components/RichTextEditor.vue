<script setup lang="ts">
import { watch } from "vue";
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import {
    Bold,
    Italic,
    List,
    ListOrdered,
    Heading1,
    Heading2,
    Quote,
    Undo2,
    Redo2,
} from "lucide-vue-next";
import { cn } from "@/lib/utils";

const props = withDefaults(
    defineProps<{
        class?: string;
    }>(),
    { class: "" },
);

const model = defineModel<string>({ required: true });

const editor = useEditor({
    content: model.value,
    extensions: [StarterKit],
    editorProps: {
        attributes: {
            class: "prose prose-sm max-w-none focus:outline-none min-h-32 px-3 py-2",
        },
    },
    onUpdate: ({ editor }) => {
        const html = editor.getHTML();
        if (html !== model.value) {
            model.value = html;
        }
    },
});

watch(model, (next) => {
    if (!editor.value) {
        return;
    }
    if (next !== editor.value.getHTML()) {
        editor.value.commands.setContent(next ?? "", { emitUpdate: false });
    }
});

type ToolbarButton = {
    icon: typeof Bold;
    label: string;
    action: () => void;
    isActive?: () => boolean;
    disabled?: () => boolean;
};

const buttons = (): ToolbarButton[] => {
    const e = editor.value;
    if (!e) return [];

    return [
        { icon: Bold, label: "Bold", action: () => e.chain().focus().toggleBold().run(), isActive: () => e.isActive("bold") },
        { icon: Italic, label: "Italic", action: () => e.chain().focus().toggleItalic().run(), isActive: () => e.isActive("italic") },
        { icon: Heading1, label: "Heading 1", action: () => e.chain().focus().toggleHeading({ level: 1 }).run(), isActive: () => e.isActive("heading", { level: 1 }) },
        { icon: Heading2, label: "Heading 2", action: () => e.chain().focus().toggleHeading({ level: 2 }).run(), isActive: () => e.isActive("heading", { level: 2 }) },
        { icon: List, label: "Bullet list", action: () => e.chain().focus().toggleBulletList().run(), isActive: () => e.isActive("bulletList") },
        { icon: ListOrdered, label: "Ordered list", action: () => e.chain().focus().toggleOrderedList().run(), isActive: () => e.isActive("orderedList") },
        { icon: Quote, label: "Blockquote", action: () => e.chain().focus().toggleBlockquote().run(), isActive: () => e.isActive("blockquote") },
        { icon: Undo2, label: "Undo", action: () => e.chain().focus().undo().run(), disabled: () => !e.can().undo() },
        { icon: Redo2, label: "Redo", action: () => e.chain().focus().redo().run(), disabled: () => !e.can().redo() },
    ];
};
</script>

<template>
    <div :class="cn('rounded-md border border-input bg-transparent overflow-hidden', props.class)">
        <div class="flex flex-wrap items-center gap-1 border-b border-input bg-muted/30 p-1">
            <button
                v-for="(button, index) in buttons()"
                :key="index"
                type="button"
                :title="button.label"
                :disabled="button.disabled?.() ?? false"
                :class="[
                    'inline-flex h-7 w-7 items-center justify-center rounded text-muted-foreground transition-colors hover:bg-muted hover:text-foreground disabled:pointer-events-none disabled:opacity-40',
                    button.isActive?.() ? 'bg-muted text-foreground' : '',
                ]"
                @click="button.action"
            >
                <component :is="button.icon" class="size-4" />
            </button>
        </div>
        <EditorContent :editor="editor" />
    </div>
</template>

<style>
.ProseMirror {
    min-height: 8rem;
}
.ProseMirror:focus {
    outline: none;
}
.ProseMirror p.is-editor-empty:first-child::before {
    color: hsl(var(--muted-foreground));
    content: attr(data-placeholder);
    float: left;
    height: 0;
    pointer-events: none;
}
</style>
