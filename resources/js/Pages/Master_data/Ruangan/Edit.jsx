import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-react";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import SecondaryButton from "@/Components/SecondaryButton";
import PrimaryButton from "@/Components/PrimaryButton";

export default function Edit(props) {
    const { id, ruangan } = usePage().props.data;

    const { data, setData, put, processing, errors, reset } = useForm({
        ruangan: ruangan || "",
    });

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        put(`/ruangan/${id}`);
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Ruangan
                </h2>
            }
        >
            <Head title="Tambah Ruangan " />
            <div className="pt-5 px-8 flex justify-end">
                <Link
                    href={route("ruangan.index")}
                    className="btn btn-sm bg-neutral "
                >
                    Kembali
                </Link>
            </div>

            <div className="py-5">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white w-1/2  overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-5">
                            <h1 className="text-2xl mb-3">Form Ruangan</h1>
                            <form onSubmit={handleSubmit}>
                                <div className="mb-3">
                                    <InputLabel
                                        forInput="ruangan"
                                        value="ruangan"
                                    />
                                    <TextInput
                                        id="ruangan"
                                        type="text"
                                        name="ruangan"
                                        value={data.ruangan}
                                        handleChange={onHandleChange}
                                        className="mt-1 block w-full"
                                        isFocused={true}
                                    />
                                    <InputError
                                        message={props.errors.ruangan}
                                        className="mt-2"
                                    />
                                </div>
                                <SecondaryButton
                                    className="mr-3"
                                    onClick={() => reset()}
                                >
                                    Reset
                                </SecondaryButton>
                                <PrimaryButton type="submit">
                                    Submit
                                </PrimaryButton>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
