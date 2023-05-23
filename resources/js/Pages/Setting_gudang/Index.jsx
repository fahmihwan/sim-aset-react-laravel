import DangerButton from "@/Components/DangerButton";
import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/inertia-react";
import { Link } from "@inertiajs/inertia-react";

const Index = (props) => {
    const { errors } = usePage().props;

    const handleDelete = (id) => {
        confirm("apakah anda yakin ingin menghapus?") &&
            Inertia.delete(`/setting/gudang/${id}`);
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Setting gudang
                </h2>
            }
        >
            <Head title="Ruangan" />

            <div className="pt-5 px-8  flex justify-end">
                <Link
                    href={route("gudang.create")}
                    className="btn btn-sm bg-neutral "
                >
                    Setting gudang
                </Link>
            </div>

            <div className="py-5">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-10">
                        <div className="overflow-x-auto">
                            <table className="table w-full">
                                <thead>
                                    <tr>
                                        <th className="bg-neutral text-white">
                                            No
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Ruangan
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Created At
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {props?.data?.map((d, i) => (
                                        <tr key={i}>
                                            <td>{i + 1}</td>
                                            <td>{d.ruangan.ruangan}</td>
                                            <td>{d.created_at}</td>
                                            <td>
                                                <button
                                                    onClick={() =>
                                                        handleDelete(d.id)
                                                    }
                                                    className="btn btn-sm btn-error "
                                                >
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    ))}

                                    {props?.data?.length == 0 && (
                                        <tr>
                                            <td
                                                colSpan={4}
                                                className="text-center"
                                            >
                                                Data Belum Ada
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>

                            {/* <Pagination
                                totals={props?.asets.total}
                                className="mt-2"
                                links={props?.asets.links}
                            /> */}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default Index;
