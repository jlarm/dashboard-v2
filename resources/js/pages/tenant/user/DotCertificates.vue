<script setup lang="ts">
import UserController from '@/actions/App/Http/Controllers/Tenant/UserController';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import EmployeeShowLayout from '@/pages/tenant/user/components/EmployeeShowLayout.vue';
import type { EmployeeShowProps } from '@/pages/tenant/user/components/types';
import { router, setLayoutProps } from '@inertiajs/vue3';
import { Download, FileText } from 'lucide-vue-next';
import { ref } from 'vue';

type Certificate = {
    id: number;
    course_name: string;
    issued_on: string;
    download_url: string;
};

defineOptions({ layout: EmployeeShowLayout });

const props = defineProps<
    EmployeeShowProps & {
        certificates: Certificate[];
        canGenerateDotCert: boolean;
    }
>();

setLayoutProps<{ activeTab: 'dot-certificates' }>({ activeTab: 'dot-certificates' });

const isGenerating = ref(false);

const generate = () => {
    isGenerating.value = true;
    router.post(
        UserController.generateDotCertificate.url({ slug: props.employee.slug }),
        {},
        {
            preserveScroll: true,
            onFinish: () => {
                isGenerating.value = false;
            },
        },
    );
};
</script>

<template>
    <div class="space-y-4">
        <div v-if="canGenerateDotCert" class="flex items-center justify-between rounded-md border bg-card p-4">
            <div>
                <p class="text-sm font-semibold">Generate DOT Certificate</p>
                <p class="mt-1 text-xs text-muted-foreground">
                    {{ employee.name }} passed the DOT Hazardous Materials course within the last three years and has no certificate on file.
                </p>
            </div>
            <Button :disabled="isGenerating" @click="generate">
                <FileText class="size-4" />
                {{ isGenerating ? 'Generating...' : 'Generate' }}
            </Button>
        </div>

        <div class="rounded-md border">
            <Table class="table-fixed">
                <TableHeader class="bg-muted">
                    <TableRow>
                        <TableHead>Certificate</TableHead>
                        <TableHead class="w-48">Issued</TableHead>
                        <TableHead class="w-32 text-right" />
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="cert in certificates" :key="cert.id">
                        <TableCell class="truncate" :title="cert.course_name">
                            {{ cert.course_name }}
                        </TableCell>
                        <TableCell class="text-muted-foreground">
                            {{ cert.issued_on }}
                        </TableCell>
                        <TableCell class="text-right">
                            <a
                                :href="cert.download_url"
                                target="_blank"
                                rel="noopener"
                                class="inline-flex items-center gap-1 text-sm font-medium text-primary hover:underline"
                            >
                                <Download class="size-4" />
                                Download
                            </a>
                        </TableCell>
                    </TableRow>
                    <TableRow v-if="certificates.length === 0">
                        <TableCell :colspan="3" class="py-10 text-center text-sm text-muted-foreground">
                            No certificates on file.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
