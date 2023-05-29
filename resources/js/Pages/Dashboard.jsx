import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, usePage } from "@inertiajs/inertia-react";
import { useEffect, useState } from "react";
import Chart from "chart.js/auto";
import { Line } from "react-chartjs-2";

export default function Dashboard(props) {
    const { aset_masuk, detail_aset_mutasi, detail_aset_penghapusan } =
        usePage().props;

    let dataAsetMasuk = [];
    let dataAsetMutasi = [];
    let dataAsetPenghapusan = [];

    for (let i = 0; i <= 11; i++) {
        dataAsetMasuk.push(0);
        dataAsetMutasi.push(0);
        dataAsetPenghapusan.push(0);
    }
    detail_aset_mutasi.forEach((e) => {
        dataAsetMutasi[e.bulan - 1] = e.total;
    });

    aset_masuk.forEach((e) => {
        dataAsetMasuk[e.bulan - 1] = e.total;
    });
    detail_aset_penghapusan.forEach((e) => {
        dataAsetPenghapusan[e.bulan - 1] = e.total;
    });

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className=" max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {/* start */}
                    <div className="stats shadow mb-5">
                        <InfoMasuk count={props.masuk} />
                        <InfoMutasi count={props.mutasi} />
                        <InfoPenghapusan count={props.penghapusan} />
                    </div>
                    {/* endstat */}

                    <div className="border w-full md:w-8/12 bg-white p-3">
                        <div>
                            <p className="font-bold">Grafik Transaksi</p>
                        </div>
                        <LineChart
                            dataAsetMasuk={dataAsetMasuk}
                            dataAsetMutasi={dataAsetMutasi}
                            dataAsetPenghapusan={dataAsetPenghapusan}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

const labels = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
];

const LineChart = ({ dataAsetMasuk, dataAsetMutasi, dataAsetPenghapusan }) => {
    return (
        <div>
            <Line
                data={{
                    labels: labels,
                    datasets: [
                        {
                            label: "Aset Masuk",
                            backgroundColor: "rgb(54,211,153)",
                            borderColor: "rgb(73,211,126)",
                            data: dataAsetMasuk,
                        },
                        {
                            label: "Aset Mutasi",
                            backgroundColor: "rgb(251,189,35)",
                            borderColor: "rgb(251,189,35)",
                            data: dataAsetMutasi,
                        },
                        {
                            label: "Aset Penghapusan",
                            backgroundColor: "rgb(255, 99, 132)",
                            borderColor: "rgb(255, 99, 132)",
                            data: dataAsetPenghapusan,
                        },
                    ],
                }}
            />
        </div>
    );
};

const InfoMasuk = ({ count }) => {
    return (
        <div className="stat">
            <div className="stat-figure text-secondary">
                {/* <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    className="inline-block w-8 h-8 stroke-current"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
                </svg> */}
                <i class="fa-solid fa-truck-ramp-box text-2xl"></i>
            </div>
            <div className="stat-title">Aset Masuk</div>
            <div className="stat-value">{count}</div>
            {/* <div className="stat-desc">Jan 1st - Feb 1st</div> */}
        </div>
    );
};

const InfoMutasi = ({ count }) => {
    return (
        <div className="stat">
            <div className="stat-figure text-secondary">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    className="inline-block w-8 h-8 stroke-current"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"
                    ></path>
                </svg>
            </div>
            <div className="stat-title">Aset Keluar</div>
            <div className="stat-value">{count}</div>
            {/* <div className="stat-desc">↗︎ 400 (22%)</div> */}
        </div>
    );
};

const InfoPenghapusan = ({ count }) => {
    return (
        <div className="stat">
            <div className="stat-figure text-secondary">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    className="inline-block w-8 h-8 stroke-current"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth="2"
                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                    ></path>
                </svg>
            </div>
            <div className="stat-title">Penghpausan</div>
            <div className="stat-value">{count}</div>
            {/* <div className="stat-desc">↘︎ 90 (14%)</div> */}
        </div>
    );
};
